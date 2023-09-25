<?php
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //controllerの読み込み
require_once(dirname(__FILE__) . '/../../const/common_const.php');                  //定義用php

class ConfirmController extends Controller {

    public function index()
    {
        // POSTの入力値が空かをチェック
        if ("POST" !== $_SERVER['REQUEST_METHOD']) {
            $_POST = [];
            header("Location: /form/");
            exit;
        }

        //セッションに保存されている値を表示用の値として代入
        $values = $_POST;

        return $values;
    }
}