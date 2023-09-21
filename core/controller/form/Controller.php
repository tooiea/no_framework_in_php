<?php

class Controller {
    
    /**
     * 入力チェック
     * @param array $value form入力された配列
     * @return array 判定[0]、エラーメッセージ[1]、変換された値[2]
     */
    function checkInputData($value) {
        
        $result = false; //エラーメッセージ有無のチェック
        $errorMsg = $this->checkAll($value); //エラーメッセージ取得
        $result = $this->msgCheck($errorMsg);

        return array($result, $errorMsg);
    }

    /**
     * エラーメッセージが含まれているかをチェック
     * @param array $errorMsg エラーメッセージの配列
     * @return bool メッセージがあればtrue
     */
    function msgCheck($errorMsg) {
        $result = false;
        foreach ($errorMsg as $msg) {
            if (!empty($msg)) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    /**
     * form画面の全項目入力チェック
     * @param array $value formで入力された配列
     * @return array チェック後のエラーメッセージの配列
     */
    function checkAll($value) {

        //各項目の入力チェック後、エラーメッセージの配列へ代入
        $errorMsg = array();

        //お名前メッセージ取得
        $errorMsg['name1'] = checkText($value['name1'], CHECK_NUMBER_DIGIT_255, 'お名前：性');
        $errorMsg['name2'] = checkText($value['name2'], CHECK_NUMBER_DIGIT_255, 'お名前：名');

        //フリガナメッセージ取得
        $errorMsg['kana1'] = checkKana($value['kana1'], CHECK_NUMBER_DIGIT_255, 'フリガナ：セイ');
        $errorMsg['kana2'] = checkKana($value['kana2'], CHECK_NUMBER_DIGIT_255, 'フリガナ：メイ');

        //性別メッセージ取得
        if (isset($value['sex'])) {
            $errorMsg['sex'] = checkRadio($value['sex'], SEX_LIST, '性別');
        } else if (!isset($value['sex'])){
            $errorMsg['sex'] = checkRadio("", SEX_LIST, '性別');
        }

        //年齢メッセージ取得
        $errorMsg['age'] = checkSelect($value['age'], AGE_LIST, '年齢');

        //血液型メッセージ取得
        if (isset($value['blood_type'])) {
            $errorMsg['blood_type'] = checkRadio($value['blood_type'], BLOOD_LIST, '血液型');
        } else if (!isset($blood_type)){
            $errorMsg['blood_type'] = checkRadio("", BLOOD_LIST, '血液型');
        }

        //職業メッセージ取得
        $errorMsg['job'] = checkSelect($value['job'], JOB_LIST, '職業');

        //郵便番号（上下）チェック後の結果、msg振り分け
        $errorMsg['zip1'] =checkNum($value['zip1'], CHECK_NUMBER_DIGIT_3, '郵便番号上');
        $errorMsg['zip2'] = checkNum($value['zip2'], CHECK_NUMBER_DIGIT_4, '郵便番号下');

        //都道府県メッセージ取得
        $errorMsg['address1'] = checkSelect($value['address1'], PREFUCTURES_LIST, '都道府県');

        //住所メッセージ取得
        $errorMsg['address2'] = checkText($value['address2'], CHECK_NUMBER_DIGIT_255, '住所');

        //ビル・マンションメッセージ取得
        $errorMsg['address3'] = checkAddress3($value['address3'], CHECK_NUMBER_DIGIT_255, 'ビル・マンション名');

        //電話番号（1,2,3）チェック後の結果、msg振り分け
        $errorMsg['tel1'] = checkNum($value['tel1'], CHECK_NUMBER_DIGIT_5, '電話番号1');
        $errorMsg['tel2'] = checkNum($value['tel2'], CHECK_NUMBER_DIGIT_4, '電話番号2');
        $errorMsg['tel3'] = checkNum($value['tel3'], CHECK_NUMBER_DIGIT_4, '電話番号3');

        //メールメッセージ取得
        $errorMsg['mail'] = checkMail($value['mail'], CHECK_NUMBER_DIGIT_255, 'メールアドレス');
        $errorMsg['mail2'] = checkMail2($value['mail'],$value['mail2'], 'メールアドレス2');

        //カテゴリーメッセージ取得
        if (isset($value['category'])) {
            $errorMsg['category'] = checkCategory($value['category'], CATEGORY_LIST);
        } 

        //お問い合わせメッセージ取得
        $errorMsg['info'] = checkInfo($value['info'], 'お問い合わせ内容');
        
        return $errorMsg;
    }

        /**
     * 名前、フリガナの文字連結処理
     * @param int $num1 名前：性
     * @param int $num2 名前：名
     * @return string 文字連結処理後
     */
    public function concatenationName($num1, $num2) {
        $data = $num1 . '　' . $num2;
        return $data;
    }

    /**
     * 郵便番号の文字連結処理
     * @param int $num1 郵便番号上
     * @param int $num2 郵便番号下
     * @return string 文字連結処理後
     */
    public function concatenationZip($num1, $num2) {
        $data = $num1 . '-' . $num2;
        return $data;
    }

    /**
     * 電話番号連結処理
     * @param int $num1 電話番号1
     * @param int $num2 電話番号2
     * @param int $num3 電話番号3
     * @return string 文字連結処理後
     */
    public function concatenationTelnum($num1, $num2, $num3) {
        $data = $num1 . '-' . $num2 . '-' . $num3;
        return $data;
    }

    /**
     * 都道府県と住所の連結
     * @param string $str1 都道府県
     * @param string $str2 住所
     * @return string 文字連結処理後
     */
    public function concatenationAddress($str1,$str2) {
        $data = $str1 . $str2;
        return $data;
    } 

    /**
     * リスト以外のキーが存在していないかをチェック
     * @param array $data セッション
     * @return bool チェックした結果
     */
    public function checkKeyOfSession($data) {
        $keyCheckResult = true;
        foreach ($data as $key => $value) { //セッション内に存在していないキーが無いかをチェック
            if (!in_array($key, KEY_LIST)) {
                $keyCheckResult = false;
                break;
            }
        }
        return $keyCheckResult;
    }

    /**
     * クエリパラメータ内に不要なパラメータが存在した場合削除する
     * @param array $values クエリパラメータ
     * @return array 必要なキーの配列
     */
    public function removeKey($values) {
        $removedKeyValues = array();
        foreach ($values as $key => $value) {
            if ('contact_no' === $key || 'page_id' === $key || 'name' === $key || 'kana' === $key || 'mail' === $key) {
                $removedKeyValues[$key] = $value;
            }
        }
        return $removedKeyValues;
    }
}