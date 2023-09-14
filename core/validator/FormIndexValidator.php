<?php

require_once(dirname(__FILE__) . '/BaseValidator.php');
require_once(dirname(__FILE__) . '/../constant/FormConstant.php');

class FormIndexValidator extends BaseValidator {

    /**
     * 項目ごとにバリデーションセット
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name1' => [
                'required' => true,
                'max' => 255
            ],
            'name2' => [
                'required' => true,
                'max' => 255
            ],
            'kana1' => [
                'required' => true,
                'max' => 255,
                'regex' => '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u',
            ],
            'kana2' => [
                'required' => true,
                'max' => 255,
                'regex' => '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u',
            ],
            'sex' => [
                'required' => true,
                'in' => FormConstant::SEX_LIST
            ],
            'age' => [
                'required' => true,
                'in' => FormConstant::AGE_LIST
            ],
            'blood_type' => [
                'required' => true,
                'in' => FormConstant::BLOOD_TYPE_LIST
            ],
            'job' => [
                'required' => true,
                'in' => FormConstant::JOB_LIST
            ],
            'zip1' => [
                'required' => true,
                'integer' => true,
            ],
            'zip2' => [
                'required' => true,
                'integer' => true,
            ],
            'address1' => [
                'required' => true,
            ],
            'address2' => [
                'required' => true,
            ],
            'address3' => [
                'required' => true,
            ],
            'tel1' => [
                'required' => true,
                'integer' => true,
            ],
            'tel2' => [
                'required' => true,
                'integer' => true,
            ],
            'tel3' => [
                'required' => true,
                'integer' => true,
            ],
            'mail' => [
                'required' => true,
            ],
            'mail2' => [
                'required' => true,
            ],
            'category' => [
                'required' => false,
            ],
            'info' => [
                'required' => true,
            ]
        ];
    }
}