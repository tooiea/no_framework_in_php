<?php
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //controllerの読み込み
require_once(dirname(__FILE__) . '/../../const/common_const.php');                  //定義用php

class ConfirmController extends Controller {

    public function index()
    {
        //セッションの中身が空かどうかチェック
        if (empty($_SESSION) || "POST" !== $_SERVER['REQUEST_METHOD']) {
            session_destroy();
            header("Location: /form/");
            exit;
        }

        // セッション内の値が不正
        if ($this->isInListValue($_SESSION)) {
            session_destroy();
            header("Location: /form/");
            exit;
        }

        //セッションに保存されている値を表示用の値として代入
        $values = $_SESSION;

        return $values;
    }
}