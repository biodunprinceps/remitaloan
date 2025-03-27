<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Services\DateService;
use App\Models\RemitaDeduction;
use App\Services\RemitaService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SetupDeductionRequest;
use App\Http\Requests\CheckRemitaDataReferencingTelephoneRequest;
use App\Http\Requests\CheckRemitaDataReferencingAccountDetailsRequest;

class RemitaController extends Controller
{

    protected $remitaService;

    public function __construct(RemitaService $remitaService)
    {
        $this->remitaService = $remitaService;
    }

    public function checkRemitaDataReferencingAccountDetails(CheckRemitaDataReferencingAccountDetailsRequest $request)
    {
        return $this->remitaService->checkRemitaDataReferencingAccountDetails($request->accountnumber, $request->bankcode);
    }

    public function checkRemitaDataReferencingTelephone(CheckRemitaDataReferencingTelephoneRequest $request)
    {
        $authcode          = date("YmdHis") . rand(20,20);
        return $this->remitaService->checkRemitaDataReferencingTelephone($request->telephone,$authcode);
    }

    public function setupDeduction(SetupDeductionRequest $request)
    {
        $y = 0;
        $disbursement_date = date("d-m-Y H:i:sO", strtotime(date("Y-m-d")));
        $number_of_months = (int) $request->tenor;

        if (date("d") > 15) {
            $y                = $y + 1;
            $number_of_months = $number_of_months + 1;
        }
        $start_month = date("Y-m-20");

        for ($x = $y; $x < $number_of_months; $x++) {
            $dateOfCollection = date("d-m-Y H:i:sO", strtotime("+$x months", strtotime($start_month)));
                if (date("m", strtotime($dateOfCollection)) == 12) {
                    $dateOfCollection = date("15-m-Y H:i:sO", strtotime("+$x months", strtotime($start_month)));
                }
                $dateOfCollection             = date('d-m-Y H:i:sO', strtotime(DateService::getNextWorkingDate(date('Y-m-d', strtotime($dateOfCollection)))));
                $formatted_date_of_collection = date('d-m-Y', strtotime($dateOfCollection));
                $exist                        = RemitaDeduction::where('status', "0")->where('date_of_collection', 'LIKE', "%$formatted_date_of_collection%")->where('loanid', $request->loanid)->first();
                if ($exist) {
                    continue;
                }

                $disbursement_date = date("d-m-Y H:i:sO", strtotime(date("Y-m-d")));
                $authcode          = date("YmdHis") . rand(20,20);
                $data              = 0;
                $data              = $this->remitaService->checkRemitaDataReferencingAccountDetails($request->accountnumber, $request->bankcode);
                if (!$data) {
                    $authcode = date("YmdHis") . rand(20,20);
                    $data     = $this->remitaService->checkRemitaDataReferencingTelephone($request->telephone, $authcode);
                }

                if ($data != 0) {
                    
                    $today             = date('d-m-Y');
                    $salary_details    = $data['salaryPaymentDetails'];
                    $last_salary_entry = $salary_details[0];
                    $last_salary_date  = $last_salary_entry['paymentDate'];
                    $earlier           = new DateTime($last_salary_date);
                    $later             = new DateTime($today);
                    $days              = $later->diff($earlier)->format("%a");
                    if ($days > 35) {
                    }

                    $m = $this->remitaService->setupDeductionForAutomation($data, $request->monthly_repayment, $request->loanid, $request->telephone, $disbursement_date, $dateOfCollection, $authcode, 1, null, $request->loan_amount, null);

                    if ($m['status'] == "error" && $m['message'] == 'Customer Is Currently Suspended') {
                        
                        return [
                            'error',
                            "Customer Is Currently Suspended or not qualified for a topup",
                        ];
                        // return ['error', 'Customer not found on Remita Platform or suspended'];
                    }
                } else {
                    return ['error', 'Customer not found on Remita Platform or suspended'];
                }
        }
    }

}
