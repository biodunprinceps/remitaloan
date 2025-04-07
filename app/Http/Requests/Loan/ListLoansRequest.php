<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class ListLoansRequest extends FormRequest
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
      'status' => 'required'
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
