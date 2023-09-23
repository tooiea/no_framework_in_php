<?php
require_once(dirname(__FILE__) . '/../../validation/FormValidator.php');           //バリデーション用ファイル
require_once(dirname(__FILE__) . '/../../const/data.php');                      //定義用php
require_once(dirname(__FILE__) . '/../../controller/form/Controller.php');      //controllerの読み込み

class InputController extends Controller {

    // 再表示用
    private $values;

    // 表示用バリデーションエラーメッセージ
    private $errorMsg;

    public function index()
    {
        if ("POST" === $_SERVER["REQUEST_METHOD"]) {
            //formページで送信ボタンを押したとき
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
                    // SESSION化する前に、submitの削除とセッションの中身をリセット
                    unset($this->values["submit"]);

                    // セッションに再セット
                    foreach ($this->values as $key =>$value) {
                        $_SESSION[$key] = $value;
                    }
                    header("Location: /form/confirm/");
                    exit;
                }
                // 表示用エラーメッセージ取得
                $this->errorMsg = $validator->getErrorMsgs();
            } elseif(isset($_POST['submit']) && "confirm_back" == $_POST['submit']) { //confirmページから戻ってきたとき
                $this->values = $_SESSION; //値を変換し表示用として代入
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