<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    //Custom Messages
    public function messages()
    {
        return [

            'email.required'    => __('data.name.required'),
            'email.email'       => __('data.email.email'),
            'password.required' => __('data.password.required')
        ];
    }
}
