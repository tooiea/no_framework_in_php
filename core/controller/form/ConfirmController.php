<?php
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //controllerの読み込み
require_once(dirname(__FILE__) . '/../../const/common_const.php');                  //定義用php

class ConfirmController extends Controller {

    public function index()
    {
        // セッションの中身が空か指定のキーが入っているかチェック
        if (empty($_SESSION) || "POST" !== $_SERVER['REQUEST_METHOD'] || $this->isInListValue($_SESSION)) {
            // セッション配列のクリーンアップ
            $_SESSION = [];
            header('Location: /form/');

            // テスト時はexitしない
            if (!$this->shouldExit()) {
                exit;
            }
        }

        //セッションに保存されている値を表示用の値として代入
        $values = $_SESSION;

        return $values;
    }
}