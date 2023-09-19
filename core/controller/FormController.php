<?php

require_once(dirname(__FILE__) . '/../constant/FormConstant.php');
require_once(dirname(__FILE__) . '/../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/BaseFormController.php');
require_once(dirname(__FILE__) . '/../error/SendMailException.php');
require_once(dirname(__FILE__) . '/../constant/MessageConstant.php');
require_once(dirname(__FILE__) . '/../validator/FormIndexValidator.php');
require_once(dirname(__FILE__) . '/../mailer/SendCustomerMailer.php');
require_once(dirname(__FILE__) . '/../mailer/SendAdministratorMailer.php');
require_once(dirname(__FILE__) . '/../constant/MailConstant.php');
require_once(dirname(__FILE__) . '/../model/Contact.php');

class FormController extends BaseFormController {

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
                // 入力値を変換した状態でバリデーション実施
                $values = $this->convertValues($_POST);
                $validater = new FormIndexValidator($values);
                $result = $validater->isValidated();
                if ($result) {
                    header('Location: /form/confirm/', true, 307);
                    exit();
                }
                // エラーメッセージ取得
                $errorMsg = $validater->getErrors();
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

        try {
            $contactInstance = new Contact();
            $contactInstance->beginTransaction();
            $processedDataForDB = $this->processingDataToDataBase($_POST);
            $result = $contactInstance->insert($processedDataForDB);

            // 問い合わせ者へ返信
            $valuesToCustomer = $this->processingDataToCustomer($_POST);
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
            $valuesToAdmin = $this->processingDataToAdmin($_POST);
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

            // post初期化
            $_POST = [];

            // DBへ登録
            $contactInstance->commit();
        } catch (SendMailException) {
            $msgHeader = MessageConstant::ERR_MSG_MAIL_HEADER;
            $msgBody = MessageConstant::ERR_MSG_MAIL_BODY;
            $contactInstance->rollback();
        } catch (\Throwable $th) {
            $contactInstance->rollback();
        }
        include dirname(__FILE__) . '/../view/form/complete.php';
    }

    /**
     * 問い合わせ者データ変換
     *
     * @param  array $values
     * @return array
     */
    private function processingDataToCustomer($values)
    {
        $processedValues = [
            'name' => $this->concatName($values['name1'], $values['name2']),
            'kana' => $this->concatName($values['kana1'], $values['kana2']),
            'sex' => FormConstant::SEX_LIST[$values['sex']],
            'age' => FormConstant::AGE_LIST[$values['age']],
            'blood_type' => FormConstant::BLOOD_TYPE_LIST[$values['blood_type']] . '型',
            'job' => FormConstant::JOB_LIST[$values['job']],
            'zip' => $this->concatZipNum($values['zip1'], $values['zip2']),
            'address12' => $this->concatString(FormConstant::PREFUCTURE_LIST[$values['address1']], $values['address2']),
            'address3' => $values['address3'],
            'tel' => $this->concatTel($values['tel1'], $values['tel2'], $values['tel3']),
            'mail' => $values['mail'],
            'category' => isset($values['category']) ? implode("\n", $this->covirtValueToLabel($values['category'], FormConstant::CATEGORY_LIST)) : '',
            'info' => $values['info'],
        ];
        return $processedValues;
    }

    /**
     * 管理者用データ変換
     *
     * @param  array $values
     * @return array
     */
    private function processingDataToAdmin($values)
    {
        $processedValues = [
            'time' => date("Y/m/d H:i:s"),
            'name' => $this->concatName($values['name1'], $values['name2']),
            'kana' => $this->concatName($values['kana1'], $values['kana2']),
            'sex' => FormConstant::SEX_LIST[$values['sex']],
            'age' => FormConstant::AGE_LIST[$values['age']],
            'blood_type' => FormConstant::BLOOD_TYPE_LIST[$values['blood_type']] . '型',
            'job' => FormConstant::JOB_LIST[$values['job']],
            'zip' => $this->concatZipNum($values['zip1'], $values['zip2']),
            'address12' => $this->concatString(FormConstant::PREFUCTURE_LIST[$values['address1']], $values['address2']),
            'address3' => $values['address3'],
            'tel' => $this->concatTel($values['tel1'], $values['tel2'], $values['tel3']),
            'mail' => $values['mail'],
            'category' => isset($values['category']) ? implode("\n", $this->covirtValueToLabel($values['category'], FormConstant::CATEGORY_LIST)) : '',
            'info' => $values['info'],
        ];
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

    /**
     * DB登録用でデータ加工
     *
     * @param  array $values
     * @return array
     */
    private function processingDataToDataBase($values)
    {
        $processedValues = [
            'name1' => $values['name1'],
            'name2' => $values['name2'],
            'kana1' => $values['kana1'],
            'kana2' => $values['kana2'],
            'sex' => $values['sex'],
            'age' => $values['age'],
            'blood_type' => $values['blood_type'],
            'job' => $values['job'],
            'zip1' => $values['zip1'],
            'zip2' => $values['zip2'],
            'address1' => $values['address1'],
            'address2' => $values['address2'],
            'address3' => $values['address3'],
            'tel' => $values['tel1'] . $values['tel2'] . $values['tel3'],
            'mail' => $values['mail'],
            'category' => isset($values['category']) ? implode(",", $values['category']) : '',
            'info' => $values['info'],
            'created' => date("Y/m/d H:i:s"),
            'modified' => date("Y/m/d H:i:s")
        ];
        return $processedValues;
    }
}