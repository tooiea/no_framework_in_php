<?php

require_once(dirname(__FILE__) . '/BaseValidator.php');

class FormIndexValidator extends BaseValidator {

    // 入力値
    private $values;

    // 入力値セット
    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * 項目ごとにバリデーションセット
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name1' => [
                'required',
                
            ],
            'name2' => [

            ],
            'kana1' => [

            ],
            'kana2' => [

            ],
            'sex' => [

            ],
            'age' => [

            ],
            'blood_type' => [

            ],
            'job' => [

            ],
            'zip1' => [

            ],
            'zip2' => [

            ],
            'address1' => [

            ],
            'address2' => [
                
            ],
            'address3' => [
                
            ],
            'tel1' => [
                
            ],
            'tel2' => [
                
            ],
            'tel3' => [
                
            ],
            'mail' => [
                
            ],
            'mail2' => [
                
            ],
            'category' => [

            ],
            'info' => [

            ]
        ];
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isValidated()
    {

        return true;
    }
}