<?php

require_once(dirname(__FILE__) . '/../../core/validator/BaseValidator.php');

class LoginValidator extends BaseValidator {

    /**
     * 項目ごとにバリデーションセット
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login_id' => [
                'required',
                'max' => 255,
            ],
            'password' => [
                'required',
                'max' => 255,
            ]
        ];
    }

    /**
     * エラー時のカラム名の変換用として配列をセット
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'login_id' => 'ログインID',
            'password' => 'パスワード'
        ];
    }
}