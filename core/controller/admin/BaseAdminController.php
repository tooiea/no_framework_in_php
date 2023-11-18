<?php

class BaseAdminController {
    public function __construct()
    {
        session_start();
    }

    /**
     * セッションチェック
     *
     * @return boolean
     */
    public function isLoggedin()
    {
        // フォーム用のセッション確認
        if (!empty($_SESSION['login_id'])) {
            header('Location: /admin/list');
            exit();
        }
    }
}