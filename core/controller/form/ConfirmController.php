<?php
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //controllerの読み込み
require_once(dirname(__FILE__) . '/../../const/data.php');                  //定義用php

class ConfirmController extends Controller {

    public function index()
    {
        //セッションの中身が空かどうかチェック
        if (empty($_SESSION)) {
            $_SESSION = [];
            header("Location: /form/");
            exit;
        }

        // 画面表示用の変数初期化
        $values = [];

        //セッション内のキーをチェックした結果
        $keyCheckResult = $this->checkKeyOfSession($_SESSION);

        // セッション内の値が不正
        if (!$keyCheckResult) {
            $_SESSION = [];
            header("Location: /form/");
            exit;
        }

        //セッションに保存されている値を表示用の値として代入
        $values = $_SESSION;

        return $values;
    }
}