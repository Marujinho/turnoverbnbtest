<?php

namespace Domain\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizeTransactionRequest extends FormRequest
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
            'authorization' => 'required|in:authorize,reject'
        ];
    }
}
