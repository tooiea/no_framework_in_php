<?php
require_once(dirname(__FILE__).'/../const/data.php');

//メール送信用のクラス
class SendMail {

    /**
     * メール送信
     * @param  array $data formで入力された配列
     * @return bool メール送信後の結果
     */
    public function sendingMail(array $data) {
        $results = []; //送信後の結果
        $resultTotal = true; //全部の送信結果

        //メール本体の処理受取
        $msgBodyForCustomer = $this->getBodymsgForCustomer($data);
        $msgBodyForAdmin = $this->getBodymsgForAdmin($data);

        //表示設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        //メール送信
        $results[0] = mb_send_mail($data['mail'], SUBJECT_TO_CUSTOMER, $msgBodyForCustomer, ADDRESS_MAIL_HEADER);
        $results[1] = mb_send_mail(ADDRESS_TO_ADMINISTRATOR, SUBJECT_TO_ADMINISTRATOR, $msgBodyForAdmin, ADDRESS_MAIL_HEADER);

        //送信結果の確認
        foreach ($results as $result) {
            if ($result !== true) {
                $resultTotal = false;
                break;
            }
        }
        return $resultTotal;
    }

    /**
     * メール本文を取得する
     * @param  array $data フォーム入力値
     * @return string
     */
    public function getBodymsgForCustomer(array $data)
    {
        //カテゴリーの値を変換し、本文表示用に処理
        $valueCategory = '';
        if (!empty($data['category'])) {
            $datalist = $this->getArrayInList($data['category'],CATEGORY_LIST);
            $valueCategory = implode("\n",$datalist);
        }

        //メールテンプレート読み込み(送信者用)
        $mailTemplate = file_get_contents(dirname(__FILE__).'/../template/mail/mailbody.tpl');

        //メール本文置換(送信者用)
        $searchItems = [
            '{{name}}',
            '{{kana}}',
            '{{sex}}',
            '{{age}}',
            '{{blood_type}}',
            '{{job}}',
            '{{zip}}',
            '{{address12}}',
            '{{address3}}',
            '{{tel}}',
            '{{mail}}',
            '{{category}}',
            '{{info}}'
        ];
        $replaceValues = [
            $data['name'],
            $data['kana'],
            SEX_LIST[$data['sex']],
            AGE_LIST[$data['age']],
            BLOOD_LIST[$data['blood_type']].'型',
            JOB_LIST[$data['job']], $data['zip'],
            $data['address12'],
            $data['address3'],
            $data['tel'],
            $data['mail'],
            $valueCategory,
            $data['info']
        ];
        $msgBody = str_replace($searchItems, $replaceValues, $mailTemplate);

        return $msgBody;
    }

    /**
     * メール本文を取得する
     * @param  array $data フォーム入力値
     * @return string
     */
    public function getBodymsgForAdmin(array $data)
    {
        //カテゴリーの値を変換し、本文表示用に処理
        $valueCategory = '';
        if (!empty($data['category'])) {
            $datalist = $this->getArrayInList($data['category'],CATEGORY_LIST);
            $valueCategory = implode("\n",$datalist);
        }

        //メールテンプレート読み込み（管理者用）
        $mailTemplate = file_get_contents(dirname(__FILE__).'/../template/mail/mailbody_me.tpl');

        //メール本文置換（管理者用）
        $searchItems = [
            '{{time}}',
            '{{name}}',
            '{{kana}}',
            '{{sex}}',
            '{{age}}',
            '{{blood_type}}',
            '{{job}}',
            '{{zip}}',
            '{{address12}}',
            '{{address3}}',
            '{{tel}}',
            '{{mail}}',
            '{{category}}',
            '{{info}}'
        ];
        $replaceValues = [
            date("Y/m/d H:i:s"),
            $data['name'],
            $data['kana'],
            SEX_LIST[$data['sex']],
            AGE_LIST[$data['age']],
            BLOOD_LIST[$data['blood_type']].'型',
            JOB_LIST[$data['job']],
            $data['zip'],
            $data['address12'],
            $data['address3'],
            $data['tel'],
            $data['mail'],
            $valueCategory,
            $data['info']
        ];
        $msgBody = str_replace($searchItems, $replaceValues, $mailTemplate);

        return $msgBody;
    }

    /**
     * 興味のあるカテゴリー(配列)の値取り出し
     * @param array $value 入力されたキーの配列
     * @param array $list 取り出し対象とする配列
     * @return array リストから取り出した値の配列
     */
    public function getArrayInList($value,$list) {
        $msg = array();
        foreach ($value as $key) {
            if (array_key_exists($key, $list)) {
                $msg[] = CATEGORY_LIST[$key];
            }
        }
        return $msg;
    }
}