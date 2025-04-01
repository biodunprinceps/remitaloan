<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Services\UtilitiesService;
use App\Http\Requests\Loan\ListLoansRequest;
use App\Http\Requests\Loan\ViewOneLoanRequest;
use App\Http\Requests\Loan\ChangeStatusRequest;
use App\Http\Requests\Loan\newApplicationRequest;

class LoanController extends Controller
{
    public function newApplication(newApplicationRequest $request)
    {
        $giroreference = date("YmdHis") . rand(111111, 999999) . rand(111111, 999999) . rand(111111, 999999);

        $new_loan                      = new Loan;
        $new_loan->title               = $request->title;
        $new_loan->contactphone        = $request->telephone;
        $new_loan->email               = $request->email;
        $new_loan->gender              = $request->gender;
        $new_loan->telephone           = $request->telephone;
        $new_loan->firstname           = $request->firstname;
        $new_loan->lastname            = $request->lastname;
        $new_loan->house_address       = $request->house_address;
        $new_loan->city                = $request->city;
        $new_loan->state               = $request->state;
        $new_loan->place_of_work       = $request->place_of_work;
        $new_loan->loan_amount         = $request->loan_amount;
        $new_loan->tenor               = $request->tenor;
        $new_loan->salary_bank_name    = $request->salary_bank_name;
        $new_loan->salary_bank_account = $request->salary_bank_account;
        $new_loan->ippisnumber         = $request->ippisnumber;
        $new_loan->monthly_repayment   = $request->monthly_repayment;
        $new_loan->dob                 = $request->dob;
        $new_loan->nin                 = $request->nin;
        $new_loan->giroreference       = $giroreference;
        $new_loan->loan_reason         = $request->loan_reason;
        $new_loan->status              = "NEW";
        $new_loan->bvn                 = $request->bvn;
        $new_loan->save();

        return response(['status' => 'success', 'message' => 'Loan application form successfully submitted!', "id" => "$new_loan->id"], 200);
    }

    public function viewOneLoan(ViewOneLoanRequest $request)
    {
        $loan = Loan::where('id', $request->id)->first();
        if (!$loan) {
            return response(['status' => 'error', 'message' => 'Loan not found'], 400);
        }
        return response(['status' => 'success', 'message' => 'Loan found', 'loan' => $loan], 200);
    }

    public function listLoans(ListLoansRequest $request)
    {
        $loans = Loan::where('status', $request->status)->get();
        return response(['status' => 'success', 'message' => 'Loans found', 'loans' => $loans], 200);
    }

    public function changeStatus(ChangeStatusRequest $request)
    {
        $loan = Loan::where('id', $request->id)->first();
        if (!$loan) {
            return response(['status' => 'error', 'message' => 'Loan not found'], 400);
        }
        $loan->status = $request->status;
        $loan->save();
        return response(['status' => 'success', 'message' => 'Loan status updated', 'loan' => $loan], 200);
    }

    public function loanCalculator(Request $request)
    {
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'tenor' => 'required|integer|min:1',
            'rate_per_day' => 'nullable|numeric|min:0',
            'startdate' => 'nullable|date',
        ]);

        $loan_amount = $request->input('loan_amount');
        $tenor = $request->input('tenor');
        $rate_per_day = $request->input('rate_per_day', 0.0025);
        $startdate = $request->input('startdate',date('Y-m-d'));

        $result = UtilitiesService::loanCalculator($loan_amount, $tenor, $rate_per_day, $startdate);

        return response()->json($result);
    }
}
