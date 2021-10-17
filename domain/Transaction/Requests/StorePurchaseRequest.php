<?php

namespace Domain\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
           'amount' => 'required|max:22|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
           'description' => 'required|string'
        ];
    }
}
