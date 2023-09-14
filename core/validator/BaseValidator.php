<?php

class BaseValidator {

    // 入力値
    private $values;

    // 入力値セット
    public function __construct($values)
    {
        $this->values = $values;
    }

    public function rules()
    {
        return [

        ];
    }

    /**
     * 空チェック
     *
     * @param  string|array $value
     * @return boolean
     */
    public static function isNotEmpty($value)
    {
        if (empty($value) || is_null($value)) {
            return true;
        }
        return false;
    }

    /**
     * 文字列であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isString($value)
    {
        if (!is_string($value)) {
            return true;
        }
        return false;
    }

    /**
     * 整数であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isInteger($value)
    {
        if (!is_integer($value)) {
            return true;
        }
        return false;
    }

    /**
     * 配列であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isArray($value)
    {
        if (!is_array($value)) {
            return true;
        }
        return false;
    }


    /**
     * キー名にあった関数を指定
     *
     * @return void
     */
    private function keyWithFunction()
    {
        return [
            'required' => 'isNotEmpty',
            'string' => 'isString'
        ];
    }

    private function checkAll()
    {
        // 項目ごとにルールを取り出す
        foreach ($this->rules() as $key => $rules) {
            // ルールを一つずつ取り出し、キー名にあった関数でチェックをする
            foreach ($rules as $ruleName => $content) {
                var_dump($content);
                // var_dump($content);
            }
        }
    }


    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isValidated()
    {
        $this->checkAll();
        return true;
    }
}