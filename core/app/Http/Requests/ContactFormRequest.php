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
                'bail',
                'required',
                'max:255'
            ],
            'name2' => [
                'bail',
                'required',
                'max:255'
            ],
            'kana1' => [
                'bail',
                'required',
                'max:255',
                'regex:' . FormConstant::REGEX_KANA
            ],
            'kana2' => [
                'bail',
                'required',
                'max:255',
                'regex:' . FormConstant::REGEX_KANA
            ],
            'sex' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::SEX_LIST))
            ],
            'age' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::AGE_LIST))
            ],
            'blood_type' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::BLOOD_LIST))
            ],
            'job' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::JOB_LIST))
            ],
            'zip1' => [
                'bail',
                'required',
                'regex:' . FormConstant::REGEX_ZIP1,
            ],
            'zip2' => [
                'bail',
                'required',
                'regex:' . FormConstant::REGEX_ZIP2,
            ],
            'address1' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::PREFUCTURES_LIST))
            ],
            'address2' => [
                'bail',
                'required',
                'max:255'
            ],
            'address3' => [
                'max:255'
            ],
            'tel1' => [
                'bail',
                'required',
                'regex:' . FormConstant::REGEX_TEL1,
            ],
            'tel2' => [
                'bail',
                'required',
                'regex:' . FormConstant::REGEX_TEL23,
            ],
            'tel3' => [
                'bail',
                'required',
                'regex:' . FormConstant::REGEX_TEL23,
            ],
            'mail' => [
                'bail',
                'required',
                'max:255',
                'email:rfc,filter'
            ],
            'mail2' => [
                'bail',
                'required',
                'same:mail'
            ],
            'category.*' => [
                Rule::in(array_keys(FormConstant::CATEGORY_LIST))
            ],
            'info' => [
                'bail',
                'required',
                'max:65535'
            ],
        ];
    }
}
