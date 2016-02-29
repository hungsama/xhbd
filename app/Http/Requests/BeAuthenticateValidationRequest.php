<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BeAuthenticateValidationRequest extends Request
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
            'admin_name' => 'required|min:6|max:20',
            'password' => 'required|min:6|max:20',
            'email' => 'required|email|min:4'
        ];
    }
}
