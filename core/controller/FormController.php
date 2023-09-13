<?php

require_once(dirname(__FILE__) . '/../constant/FormConstant.php');
require_once(dirname(__FILE__) . '/../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/BaseController.php');

class FormController extends BaseController {
    public function index()
    {
        // postでリクエスト
        if ($_SERVER['REQUEST_METHOD'] === 'post') {
            echo var_dump($_POST);
        }

        include dirname(__FILE__) . '/../view/form/index.php';
    }

    public function confirm()
    {
        $values = $_POST;
        include dirname(__FILE__) . '/../view/form/confirm.php';
    }

    public function complete()
    {
        include dirname(__FILE__) . '/../view/form/complete.php';
    }
}