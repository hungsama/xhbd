<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BeArticleValidationRequest extends Request
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
      'title' => 'required|min:6|max:255',
      'content' => 'required|min:6',
      'author' => 'required|min:6|max:255',
      'slide_img' => 'image|max:3000'
    ];
  }
}