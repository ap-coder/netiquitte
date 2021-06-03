<?php

namespace App\Http\Requests;

use App\Models\Account;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('account_edit');
    }

    public function rules()
    {
        return [
            'company' => [
                'string',
                'required',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
            'everflow_account' => [
                'string',
                'nullable',
            ],
        ];
    }
}
