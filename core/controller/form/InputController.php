<?php
require_once(dirname(__FILE__) . '/../../validation/FormValidator.php');
require_once(dirname(__FILE__) . '/../../const/common_const.php');
require_once(dirname(__FILE__) . '/../../controller/form/Controller.php');

class InputController extends Controller {

    // 再表示用
    private $values;

    // 表示用バリデーションエラーメッセージ
    private $errorMsg;

    /**
     * 初期表示
     * POSTリクエスト(バリデーション、確認画面から戻り)
     *
     * @return void
     */
    public function index()
    {
        if ("POST" === $_SERVER["REQUEST_METHOD"]) {
            // 入力画面から
            if (isset($_POST['submit']) && CHECK_SUBMIT_FORM == $_POST['submit']) {
                // 入力値を変換
                $this->values = $this->convertStr($_POST);

                // 入力チェック
                $validator = new FormValidator();
                $validator->checkInputData($this->values);

                // バリデーション判定結果取得
                $isVerified = $validator->getResult();

                // バリデーションエラーなし、不正な入力なし
                if ($isVerified || !$this->isInListValue($this->values)) {
                    // 強制的にPOSTで送信する
                    header("Location: /form/confirm/", true, 307);
                    exit;
                }

                // 表示用エラーメッセージ取得
                $this->errorMsg = $validator->getErrorMsgs();

            } elseif (isset($_POST['submit']) && "confirm_back" == $_POST['submit']) {
                // 確認画面からの戻り
                $this->values = $_POST; //値を変換し表示用として代入
            }
        }
    }

    /**
     * テンプレート表示用入力値を取得
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * エラーメッセージ取得
     *
     * @return array
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}