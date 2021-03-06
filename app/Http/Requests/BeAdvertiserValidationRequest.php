<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BeAdvertiserValidationRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|min:6|max:255',
      'email' => 'required',
      'address' => 'required|min:6',
      'mobile' => 'required|min:10'
    ];
  }
}
