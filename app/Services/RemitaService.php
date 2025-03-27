<?php

namespace App\Services;

use Exception;
use App\Models\RemitaResponse;
use App\Models\RemitaDeduction;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Http;

class RemitaService
{

  protected $baseUrl;
  protected $api_token;
  protected $api_key;
  protected $merchant_id;

  /**
   * __construct
   * 
   * Sets the base url, api token, api key and merchant id for the remita service
   * 
   * @return void
   */
  public function __construct()
  {
    $this->baseUrl = config('services.remita.base_url');
    $this->api_token = config('services.remita.api_token');
    $this->api_key = config('services.remita.api_key');
    $this->merchant_id = config('services.remita.merchant_id');
  }

  /**
   * Checks the status of a customer on Remita
   * 
   * This method makes a POST request to the Remita Payday API to check the status of a deduction
   * 
   * @param array $array_data The data to be sent to Remita
   * 
   * @return array The response from Remita
   * 
   * @throws \Throwable if there is an error making the request
   */
  public function checkSalary($request_id, $parameter)
    {
        $hash = hash('sha512', $this->api_key . $request_id . $this->api_token);
        $curl = curl_init();
        $url =  $this->baseUrl . "loansvc/data/api/v2/payday/salary/history/ph";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($parameter),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json",
                "authorization: remitaConsumerKey=" . $this->api_key . ", remitaConsumerToken=" . $hash,
                "merchant_id: " . $this->merchant_id,
                "request_id: " . $request_id,
                "api_key: " . $this->api_key,
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        $data = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($data) {
            if (array_key_exists('data', $data)) {
                if ($data['data']) {
                  $new_data = $data;
                  $new_data['parameter_sent'] = $parameter;
                  return $new_data;
                }
            }
        }

        return "unknown error";
        
    }


    /**
     * Checks remita data for a given account number and bank code.
     *
     * @param string $accountNumber The account number
     * @param string $bankCode The bank code
     * @return array Data returned from remita
     */
    public function checkRemitaDataReferencingAccountDetails(string $accountNumber, string $bankCode)
    {
      $data = 0;
        if ($bankCode == '221') {
            $bankCode = "039";
        }
        $authcode = date("YmdHis") .  rand(20,20);
        $parameter = array(
            'authorisationCode' => $authcode,
            'accountNumber' => $accountNumber,
            'bankCode' => $bankCode,
            'authorisationChannel' => "USSD",
        );

        $request_id = date("YmdHis") . rand(20,20);
        $check_salary = $this->checkSalary($request_id, $parameter);
        if ($check_salary) {
            if (array_key_exists('hasData', $check_salary)) {
                if ($check_salary['hasData']) {
                    return $data = $check_salary['data'];
                }
            }
        }
        return $data;
    }

    public static function checkRemitaDataReferencingTelephone($telephone, $authcode)
    {
        $telephone = trim($telephone);
        $parameter = array(
            'authorisationCode' => $authcode,
            'phoneNumber' => $telephone,
            'authorisationChannel' => "USSD",
        );
        $request_id = date("YmdHis") . rand(20,20);
        $check_salary = self::checkSalary($request_id, $parameter);
        if ($check_salary) {
            if (array_key_exists('data', $check_salary)) {
                if ($check_salary['data']) {
                    return $check_salary['data'];
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    public function setupDeductionForAutomation($data, $monthly_repayment, $loanid, $telephone, $disbursement_date, $dateOfCollection, $authcode, $tenor = 1, $authid = null, $loan_amount = 0, $bankCode = null)
    {
        if ($loan_amount == 0) {
            $loan_amount = $monthly_repayment;
        }

        $parameter = array(
            'customerId' => $data['customerId'],
            'phoneNumber' => $telephone,
            'accountNumber' => $data['accountNumber'],
            'currency' => "NGN",
            'loanAmount' => $loan_amount,
            'collectionAmount' => $monthly_repayment,
            'authorisationCode' => $authcode,
            'authorisationChannel' => "USSD",
            'dateOfDisbursement' => $disbursement_date,
            "dateOfCollection" => $dateOfCollection,
            "numberOfRepayments" => $tenor,
            'totalCollectionAmount' => $monthly_repayment * $tenor,
        );
        if ($bankCode) {
            $parameter['bankCode'] = $data['bankCode'];
        } elseif (array_key_exists('bankCode', $data)) {
            $parameter['bankCode'] = $data['bankCode'];
        }
        
        $remitadeductions = new RemitaDeduction;
        $remitadeductions->customer_id = $data['customerId'];
        $remitadeductions->amount = $monthly_repayment * $tenor;
        $remitadeductions->balance = $monthly_repayment * $tenor;
        $remitadeductions->telephone = $telephone;
        $remitadeductions->loanid = $loanid;
        $remitadeductions->start_date = date('Y-m-d');
        $remitadeductions->date_of_collection = $dateOfCollection;
        $remitadeductions->authcode = $authcode;
        $remitadeductions->created_by = 'cp21eji429fh24rfh3034fjdf2327230jfb23';
        if ($authid != null) {
            $remitadeductions->created_by = $authid;
        }
        $remitadeductions->setup_type = 1;
        if ($tenor > 1) {
            $remitadeductions->no_of_times = $tenor;
            $remitadeductions->type = 'Recurring';
        }

        $request_id = date("YmdHis") . rand(20,20);
        $disburse_loan = self::disburseLoan($request_id, $parameter);
        RemitaResponse::create(['loanid' => $loanid, 'data' => json_encode($disburse_loan), 'request_id' => $request_id, 'parameter' => json_encode($parameter)]);
        $data = (object) $disburse_loan;
        if (!property_exists($disburse_loan, 'status')) {
            $remitadeductions->save();
            return ['status' => 'error', 'data' => $data, "message" => 'error'];
        }
        if ($disburse_loan->status == "success" && $disburse_loan->hasData) {
            $data = (object) $disburse_loan->data;
            $remitadeductions->customer_id = $data->customerId;
            $remitadeductions->mandatereference = $data->mandateReference;
            $remitadeductions->save();
            return ['status' => 'success', 'data' => $data->mandateReference, "message" => 'success'];
        } else {
            return ['status' => 'error', 'data' => $data, "message" => $data->responseMsg];
        }
    }


    public function disburseLoan($request_id, $parameter)
    {
        $hash = hash('sha512', $this->api_key . $request_id . $this->api_token);
        $curl = curl_init();
        $url =  $this->baseUrl . "loansvc/data/api/v2/payday/post/loan";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($parameter),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json",
                "authorization: remitaConsumerKey=" . $this->api_key . ", remitaConsumerToken=" . $hash,
                "merchant_id: " . $this->merchant_id,
                "request_id: " . $request_id,
                "api_key: " . $this->api_key,
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        $data = (object) json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return $data;
    }
}
