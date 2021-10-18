<?php

namespace Domain\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
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
           'check'  => 'required|file|mimes:jpeg,jpg,png|max:10000',
           'amount' => 'required|gt:0|max:22|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
           'description' => 'required|string'
        ];
    }
}
