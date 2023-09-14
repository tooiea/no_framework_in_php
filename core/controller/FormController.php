<?php

require_once(dirname(__FILE__) . '/../constant/FormConstant.php');
require_once(dirname(__FILE__) . '/../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/BaseController.php');

class FormController extends BaseController {
    public function index()
    {
        // postでリクエスト
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            header('Location: /form/confirm/', true, 307);
            exit();
        }

        include dirname(__FILE__) . '/../view/form/index.php';
    }

    public function confirm()
    {
        $values = $_POST;
        var_dump($values);
        include dirname(__FILE__) . '/../view/form/confirm.php';
    }

    public function complete()
    {
        include dirname(__FILE__) . '/../view/form/complete.php';
    }
}