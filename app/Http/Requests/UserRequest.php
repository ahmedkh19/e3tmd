<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required|string|alpha_dash|max:255|unique:users,username',
            'mobile' => 'required|unique:users,mobile|phone:country',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];
    }
}
