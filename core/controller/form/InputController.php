<?php
require_once(dirname(__FILE__) . '/../../validation/validation.php');           //バリデーション用ファイル
require_once(dirname(__FILE__) . '/../../const/data.php');                      //定義用php
require_once(dirname(__FILE__) . '/../../controller/form/Controller.php');      //controllerの読み込み

class InputController extends Controller{

    public function index() {

        $values = array();
        $errorMsg = array();
    
        if ("POST" === $_SERVER["REQUEST_METHOD"]) {
            //formページで送信ボタンを押したとき
            if (isset($_POST['submit']) && "form_submit" == $_POST['submit']) {
                $values = convertStr($_POST); //半角⇆全角の変換処理
                $results = $this->checkInputData($values); //入力チェック
                $resultCheck = $results[0]; //バリデーション判定結果
                $errorMsg = $results[1];  //表示用エラーメッセージ
                unset($values["submit"]); //SESSION化する前に、submitの削除

                if (!$resultCheck) {
                    $_SESSION = array();
                    foreach ($values as $key =>$value) {
                        $_SESSION[$key] = $value;
                    }
                    header("Location: /form/confirm/");
                    exit;
                }
            } else if(isset($_POST['submit']) && "confirm_back" == $_POST['submit']) { //confirmページから戻ってきたとき
                $values = $_SESSION; //値を変換し表示用として代入
            }
        }
        return array($values, $errorMsg);
    }
}