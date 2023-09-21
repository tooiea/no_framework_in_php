<?php
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //controllerの読み込み
require_once(dirname(__FILE__) . '/../../const/data.php');                  //定義用php

class ConfirmController extends Controller{

    public function index() {

        $values = array(); //画面表示用の変数

        if (!empty($_SESSION)) { //セッションの中身が空かどうかチェック
            $keyCheckResult = $this->checkKeyOfSession($_SESSION); //セッション内のキーをチェックした結果
        } else {
            $keyCheckResult = false;
        }

        if ($keyCheckResult) { //セッション内のキーをチェックした結果
            $values = $_SESSION; //セッションに保存されている値を表示用の値として代入
        } else { //セッション内に、存在しないキーが合った場合（セッションが存在しない場合）
            $_SESSION = array();
            header("Location: /form/");
            exit;
        }
        return $values;
    }
}