<?php

require_once(dirname(__FILE__) . '/../constant/FormConstant.php');
require_once(dirname(__FILE__) . '/../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/BaseController.php');
require_once(dirname(__FILE__) . '/../error/SendMailException.php');
require_once(dirname(__FILE__) . '/../constant/MessageConstant.php');
require_once(dirname(__FILE__) . '/../validator/FormIndexValidator.php');

class FormController extends BaseController {

    /**
     * 入力画面
     *
     * @return void
     */
    public function index()
    {
        // postでリクエスト
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            // 戻るボタン
            if (FormConstant::SUBMIT_CONFIRM_BACK === $_POST['submit']) {
                $values = $_POST;
            } else {
                $validater = new FormIndexValidator($_POST);
                $validater->isValidated();
                // TODO バリデーション
                // header('Location: /form/confirm/', true, 307);
                // exit();
            }
        }

        include dirname(__FILE__) . '/../view/form/index.php';
    }

    /**
     * 確認画面
     *
     * @return void
     */
    public function confirm()
    {
        // 画面用で変数にセット
        $values = $_POST;

        // POSTの入力値をクリア
        $_POST = [];
        include dirname(__FILE__) . '/../view/form/confirm.php';
    }

    /**
     * 完了画面
     *
     * @return void
     */
    public function complete()
    {
        $values = $_POST;
        var_dump($values);
        try {
            // メール送信判定
            // if (false) {
                // throw new SendMailException();
            // }
            $msgHeader = MessageConstant::SUCCESS_SEND_MAIL_HEADER;
            $msgBody = MessageConstant::SUCCESS_SEND_MAIL_BODY;
            $_POST = [];
        } catch (SendMailException) {
            $msgHeader = MessageConstant::ERR_MSG_MAIL_HEADER;
            $msgBody = MessageConstant::ERR_MSG_MAIL_BODY;
        } catch (\Throwable $th) {
            //throw $th;
        }
        include dirname(__FILE__) . '/../view/form/complete.php';
    }
}