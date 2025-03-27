<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class SetupDeductionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tenor' => 'required',
            'loanid' => 'required',
            'accountnumber' => 'required',
            'bankcode' => 'required',
            'telephone' => 'required',
            'monthly_repayment' => 'required',
            'loan_amount' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
    
        $response = response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 400);
        
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException("You don't have the authority to perform this resource");
    }
}
