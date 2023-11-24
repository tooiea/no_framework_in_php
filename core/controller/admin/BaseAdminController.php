<?php

require_once(dirname(__FILE__) . '/../Controller.php');

class BaseAdminController extends Controller {

    /**
     * ログイン済みのユーザである
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

    /**
     * 
     *
     * @return boolean
     */
    public function isLoggedinUser()
    {
        // フォーム用のセッション確認
        if (empty($_SESSION['login_id'])) {
            header('Location: /admin/login');
            exit();
        }
    }
}