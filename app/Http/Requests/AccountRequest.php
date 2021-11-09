<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'name' => 'required|max:100',
           // 'slug' => 'required|unique:products,slug,'. $this->id,
            'description' => 'required|max:500',
            'short_description' => 'nullable|max:150',
            'pricing_method' => 'required',
            'price' => 'required_if:pricing_method,Fixed|nullable',
            'start_bid_amount' => 'required_if:pricing_method,Auction|nullable',
            'auction_start' => 'required_if:pricing_method,Auction|nullable|date',
            'auction_end' => 'required_if:pricing_method,Auction|nullable|date',
            'account_email' => 'required_with:account_password,account_confirm_password,account_security_questions,account_username,account_email_website|nullable|email',
            'account_password' => 'required_with:account_email,account_confirm_password,account_security_questions,account_username,account_email_website|nullable',
            'account_confirm_password' => 'required_with:account_password,account_email,account_security_questions,account_username,account_email_website|nullable|same:account_password',
            'account_username' => 'required_with:account_password,account_email,account_security_questions,account_confirm_password,account_email_website|nullable',
            'account_email_website' => 'required_with:account_password,account_email,account_security_questions,account_confirm_password,account_username|nullable',
          //  'account_security_questions' => 'array|min:2|required_with:account_email,account_confirm_password,account_password,account_username,account_email_website|nullable',
            'categories' => 'array|min:1', //[]
            'categories.*' => 'required|numeric|exists:categories,id',
        ];
    }
}
