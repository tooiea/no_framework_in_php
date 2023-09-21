<?php
require_once(dirname(__FILE__) . '/../../validation/FormValidator.php');           //バリデーション用ファイル
require_once(dirname(__FILE__) . '/../../const/data.php');                      //定義用php
require_once(dirname(__FILE__) . '/../../controller/form/Controller.php');      //controllerの読み込み

class InputController extends Controller{

    private $values;
    private $errorMsg;

    public function index()
    {
        $validator = new FormValidator();

        if ("POST" === $_SERVER["REQUEST_METHOD"]) {
            //formページで送信ボタンを押したとき
            if (isset($_POST['submit']) && CHECK_SUBMIT_FORM == $_POST['submit']) {
                $this->values = $this->convertStr($_POST); //半角⇆全角の変換処理
                $validator->checkInputData($this->values); //入力チェック
                $resultCheck = $validator->getResult(); //バリデーション判定結果
                $this->errorMsg = $validator->getErrorMsgs();  //表示用エラーメッセージ
                unset($this->values["submit"]); //SESSION化する前に、submitの削除

                // バリデーションエラー
                if (!$resultCheck) {
                    $_SESSION = [];
                    foreach ($this->values as $key =>$value) {
                        $_SESSION[$key] = $value;
                    }
                    header("Location: /form/confirm/");
                    exit;
                }
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