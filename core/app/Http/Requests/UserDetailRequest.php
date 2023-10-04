<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailRequest extends FormRequest
{
    // リダイレクト先の指定
    protected $redirectRoute = 'admin.user_list';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_no' => [
                'bail',
                'required',
                'integer',
                'exists:App\Models\Contact,contact_no'
            ]
        ];
    }

    /**
     * ルートパラメータをリクエストにマージ
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['contact_no' => $this->route('id')]);
    }
}
