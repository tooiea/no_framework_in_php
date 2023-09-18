<?php

require_once(dirname(__FILE__) . '/../constant/FormConstant.php');
require_once(dirname(__FILE__) . '/../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/BaseController.php');
require_once(dirname(__FILE__) . '/../error/SendMailException.php');
require_once(dirname(__FILE__) . '/../constant/MessageConstant.php');
require_once(dirname(__FILE__) . '/../validator/FormIndexValidator.php');
require_once(dirname(__FILE__) . '/../mailer/SendCustomerMailer.php');
require_once(dirname(__FILE__) . '/../mailer/SendAdministratorMailer.php');
require_once(dirname(__FILE__) . '/../constant/MailConstant.php');
require_once(dirname(__FILE__) . '/../model/Contact.php');

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
                $result = $validater->isValidated();
                if ($result) {
                    header('Location: /form/confirm/', true, 307);
                    exit();
                }
                // エラーメッセージ取得
                $errorMsg = $validater->getErrors();
                $values = $_POST;
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
        $validater = new FormIndexValidator($_POST);
        $result = $validater->isValidated();

        // 直アクセスされた、入力値が正常でない場合
        if (empty($_POST) || !$result) {
            header('Location: /form/');
            exit();
        }

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
        $validater = new FormIndexValidator($_POST);
        $result = $validater->isValidated();

        // 直アクセスされた、入力値が正常でない場合
        if (empty($_POST) || !$result) {
            header('Location: /form/');
            exit();
        }

        // try {
            // TODO DBアクセス
            $contact = new Contact();
            var_dump($contact->insert($_POST));


            // 問い合わせ者へ返信
            $valuesToCustomer = $this->processingCustomerValues($_POST);
            $mailToCustomer = new SendCustomerMailer(
                $valuesToCustomer['mail'],
                MailConstant::SUBJECT_TO_CUSTOMER,
                MailConstant::ADDRESS_MAIL_HEADER,
                file_get_contents(dirname(__FILE__) . '/../view/mail/mailbody_customer.tpl'),
            );
            $result = $mailToCustomer->sendMail($valuesToCustomer);

            // メール送信判定
            if (!$result) {
                throw new SendMailException();
            }

            // 管理者へ送信
            $valuesToAdmin = $this->processingAdminValues($_POST);
            $mailToAdmin = new SendAdministratorMailer(
                MailConstant::ADDRESS_TO_ADMINISTRATOR,
                MailConstant::SUBJECT_TO_ADMINISTRATOR,
                MailConstant::ADDRESS_MAIL_HEADER,
                file_get_contents(dirname(__FILE__) . '/../view/mail/mailbody_unt.tpl'),
            );
            $result = $mailToAdmin->sendMail($valuesToAdmin);

            // メール送信判定
            if (!$result) {
                throw new SendMailException();
            }

            $msgHeader = MessageConstant::SUCCESS_SEND_MAIL_HEADER;
            $msgBody = MessageConstant::SUCCESS_SEND_MAIL_BODY;
            $_POST = [];
        // } catch (SendMailException) {
        //     $msgHeader = MessageConstant::ERR_MSG_MAIL_HEADER;
        //     $msgBody = MessageConstant::ERR_MSG_MAIL_BODY;
        // } catch (\Throwable $th) {
        //     // TODO DBのロールバック内容記載
        //     //throw $th;
        // }
        include dirname(__FILE__) . '/../view/form/complete.php';
    }

    /**
     * 問い合わせ者データ変換
     *
     * @param  array $values
     * @return array
     */
    private function processingCustomerValues($values)
    {
        $processedValues['name'] = $this->concatName($values['name1'], $values['name2']);
        $processedValues['kana'] = $this->concatName($values['kana1'], $values['kana2']);
        $processedValues['sex'] = FormConstant::SEX_LIST[$values['sex']];
        $processedValues['age'] = FormConstant::AGE_LIST[$values['age']];
        $processedValues['blood_type'] = FormConstant::BLOOD_TYPE_LIST[$values['blood_type']] . '型';
        $processedValues['job'] = FormConstant::JOB_LIST[$values['job']];
        $processedValues['zip'] = $this->concatZipNum($values['zip1'], $values['zip2']);
        $processedValues['address12'] = $this->concatString(FormConstant::PREFUCTURE_LIST[$values['address1']], $values['address2']);
        $processedValues['address3'] = $values['address3'];
        $processedValues['tel'] = $this->concatTel($values['tel1'], $values['tel2'], $values['tel3']);
        $processedValues['mail'] = $values['mail'];
        $processedValues['category'] = isset($values['category']) ? implode("\n", $this->covirtValueToLabel($values['category'], FormConstant::CATEGORY_LIST)) : '';
        $processedValues['info'] = $values['info'];

        return $processedValues;
    }

    /**
     * 管理者用データ変換
     *
     * @param  array $values
     * @return array
     */
    private function processingAdminValues($values)
    {
        $processedValues['time'] = date("Y/m/d H:i:s");
        $processedValues['name'] = $this->concatName($values['name1'], $values['name2']);
        $processedValues['kana'] = $this->concatName($values['kana1'], $values['kana2']);
        $processedValues['sex'] = FormConstant::SEX_LIST[$values['sex']];
        $processedValues['age'] = FormConstant::AGE_LIST[$values['age']];
        $processedValues['blood_type'] = FormConstant::BLOOD_TYPE_LIST[$values['blood_type']] . '型';
        $processedValues['job'] = FormConstant::JOB_LIST[$values['job']];
        $processedValues['zip'] = $this->concatZipNum($values['zip1'], $values['zip2']);
        $processedValues['address12'] = $this->concatString(FormConstant::PREFUCTURE_LIST[$values['address1']], $values['address2']);
        $processedValues['address3'] = $values['address3'];
        $processedValues['tel'] = $this->concatTel($values['tel1'], $values['tel2'], $values['tel3']);
        $processedValues['mail'] = $values['mail'];
        $processedValues['category'] = isset($values['category']) ? implode("\n", $this->covirtValueToLabel($values['category'], FormConstant::CATEGORY_LIST)) : '';
        $processedValues['info'] = $values['info'];

        return $processedValues;
    }

    /**
     * 配列リストの値をラベルに変換し取得
     *
     * @param  array $value
     * @return array
     */
    private function covirtValueToLabel($values, $list) {
        $convertedValues = [];
        foreach ($values as $key) {
            if (array_key_exists($key, $list)) {
                $convertedValues[] = $list[$key];
            }
        }
        return $convertedValues;
    }
}