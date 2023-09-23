<?php
require_once(dirname(__FILE__) . '/../const/data.php');
require_once(dirname(__FILE__) . '/../validation/BaseValidator.php');

class AdminFormValidator extends BaseValidator {

    // バリデーション結果
    private $result;

    // バリデーション後のエラーメッセージ
    private $errorMsg;

    /**
     * チェック後の値で、DBで検索する
     *
     * @param  array $values
     * @return array エラーメッセージ
     */
    public function checkUserPassword(array $values)
    {
        $this->errorMsg[] = $this->nullCheck($values);
        if (empty($this->errorMsg)) {
            $this->errorMsg[] = $this->checkDigit($values);
        }
    }

    /**
     * 桁数チェック
     *
     * @param  array $values 入力値
     * @return array エラーメッセージ
     */
    public function checkDigit(array $values)
    {
        foreach ($values as $value) {
            if ($this->checkMaxDigit($value, CHECK_NUMBER_DIGIT_255)) {
                $this->errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                continue;
            }
        }
    }

    /**
     * ログインIDとパスワードが未入力でないかをチェック
     *
     * @param  array $values 入力データ
     * @return array エラーメッセージ
     */
    public function nullCheck(array $values)
    {
        foreach ($values as $key => $value) {
            if ($this->isEmpty($value)) {
                if ('login_id' === $key) {
                    $this->errorMsg[$key] = NOT_INPUT_LOGINID;
                } else {
                    $this->errorMsg[$key] = NOT_INPUT_PASSWORD;
                }
            }
        }
    }

    /**
     * バリデーション後の結果を取得
     *
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * バリデーション後のエラーメッセージ取得
     *
     * @return array|null
     */
    public function getErrorMsgs()
    {
        return $this->errorMsg;
    }
}