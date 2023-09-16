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
                'required',
                'max' => 255
            ],
            'name2' => [
                'required',
                'max' => 255
            ],
            'kana1' => [
                'required',
                'max' => 255,
                'regex' => '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u',
            ],
            'kana2' => [
                'required',
                'max' => 255,
                'regex' => '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u',
            ],
            'sex' => [
                'required',
                'in' => FormConstant::SEX_LIST
            ],
            'age' => [
                'required',
                'in' => FormConstant::AGE_LIST
            ],
            'blood_type' => [
                'required',
                'in' => FormConstant::BLOOD_TYPE_LIST
            ],
            'job' => [
                'required',
                'in' => FormConstant::JOB_LIST
            ],
            'zip1' => [
                'required',
                'regex' => '/^[0-9]{3}+$/',
            ],
            'zip2' => [
                'required',
                'regex' => '/^[0-9]{4}+$/',
            ],
            'address1' => [
                'required',
                'in' => FormConstant::PREFUCTURE_LIST
            ],
            'address2' => [
                'required',
                'max' => 255,
            ],
            'address3' => [
                'required',
                'max' => 255,
            ],
            'tel1' => [
                'required',
                'regex' => '/^[0-9]{1,5}+$/',
            ],
            'tel2' => [
                'required',
                'regex' => '/^[0-9]{1,4}+$/',
            ],
            'tel3' => [
                'required',
                'integer',
                'regex' => '/^[0-9]{1,4}+$/',
            ],
            'mail' => [
                'required',
                'email',
                'max' => 255,
            ],
            'mail2' => [
                'required',
            ],
            'category' => [
                'in' => FormConstant::CATEGORY_LIST
            ],
            'info' => [
                'required',
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name1' => 'お名前：姓',
            'name2' => 'お名前：名',
            'kana1' => 'フリガナ：セイ',
            'kana2' => 'フリガナ：メイ',
            'sex' => '性別',
            'age' => '年齢',
            'blood_type' => '血液型',
            'job' => '職業',
            'zip1' => '郵便番号（上）',
            'zip2' => '郵便番号（下）',
            'address1' => '都道府県',
            'address2' => '住所',
            'address3' => 'ビル・マンション名',
            'tel1' => '電話番号',
            'tel2' => '電話番号',
            'tel3' => '電話番号',
            'mail' => 'メールアドレス',
            'mail2' => 'メールアドレス（確認用）',
            'category' => '興味のあるカテゴリー',
            'info' => 'お問合せ内容'
        ];
    }
}