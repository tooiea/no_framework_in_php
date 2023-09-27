<?php

namespace App\Http\Requests;

use App\Constants\FormConstant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactFormRequest extends FormRequest
{
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
            'name1' => [
                'required',
                'max:255'
            ],
            'name2' => [
                'required',
                'max:255'
            ],
            'kana1' => [
                'required',
                'max:255',
                'regex:' . FormConstant::REGEX_KANA
            ],
            'kana2' => [
                'required',
                'max:255',
                'regex:' . FormConstant::REGEX_KANA
            ],
            'sex' => [
                'required',
                Rule::in(array_keys(FormConstant::SEX_LIST))
            ],
            'age' => [
                'required',
                Rule::in(array_keys(FormConstant::AGE_LIST))
            ],
            'blood_type' => [
                'required',
                Rule::in(array_keys(FormConstant::BLOOD_LIST))
            ],
            'job' => [
                'required',
                Rule::in(array_keys(FormConstant::JOB_LIST))
            ],
            'zip1' => [
                'required',
                'regex:' . FormConstant::REGEX_ZIP1,
            ],
            'zip2' => [
                'required',
                'regex:' . FormConstant::REGEX_ZIP2,
            ],
            'address1' => [
                'required',
                Rule::in(array_keys(FormConstant::PREFUCTURES_LIST))
            ],
            'address2' => [
                'required',
                'max:255'
            ],
            'address3' => [
                'max:255'
            ],
            'tel1' => [
                'required',
                'regex:' . FormConstant::REGEX_TEL1,
            ],
            'tel2' => [
                'required',
                'regex:' . FormConstant::REGEX_TEL23,
            ],
            'tel3' => [
                'required',
                'regex:' . FormConstant::REGEX_TEL23,
            ],
            'mail' => [
                'required',
                'max:255',
                'email:rfc,filter'
            ],
            'mail2' => [
                'required',
                'same:mail'
            ],
            'category.*' => [
                Rule::in(array_keys(FormConstant::CATEGORY_LIST))
            ],
            'info' => [
                'required',
                'max:65535'
            ],
        ];
    }
}
