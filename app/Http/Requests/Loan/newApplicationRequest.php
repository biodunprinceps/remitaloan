<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class newApplicationRequest extends FormRequest
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
      'title' => 'required|string|max:10',
      'telephone' => 'required|string|regex:/^\d{10,15}$/',
      'email' => 'required|email|max:255',
      'gender' => 'required|in:male,female,other',
      'firstname' => 'required|string|max:50',
      'lastname' => 'required|string|max:50',
      'house_address' => 'required|string|max:255',
      'city' => 'required|string|max:100',
      'state' => 'required|string|max:100',
      'place_of_work' => 'required|string|max:255',
      'loan_amount' => 'required|numeric|min:1000',
      'tenor' => 'required|integer|min:1',
      'salary_bank_name' => 'required|string|max:100',
      'salary_bank_account' => 'required|string|regex:/^\d{10}$/',
      'ippisnumber' => 'required|string|max:20',
      'monthly_repayment' => 'required|numeric|min:1',
      'dob' => 'required|date|before:today',
      'nin' => 'required|string|size:11',
      'loan_reason' => 'required|string|max:255',
      'bvn' => 'required|string|size:11'
    ];
  }

  protected function failedValidation(Validator $validator)
  {

    $message = '';
    foreach ($validator->errors()->all() as $error) {
      $message .= "$error <br> ";
    }
    $response = response()->json([
      'status' => 'error',
      'message' => $message,
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
