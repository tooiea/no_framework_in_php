<?php

require_once dirname(__FILE__) . '/../const/common_const.php';
require_once dirname(__FILE__) . '/../validation/BaseValidator.php';

/**
 * お問い合わせフォームバリデーション
 */
class FormValidator extends BaseValidator
{

    // バリデーション結果
    private $result;

    // バリデーション後のエラーメッセージ
    private $errorMsg;

    /**
     * フォーム画面の全項目入力チェック
     * 
     * @param array $values formで入力された配列
     * 
     * @return array チェック後のエラーメッセージの配列
     */
    public function checkAll(array $values)
    {
        // 各項目の入力チェック後、エラーメッセージの配列へ代入
        $errorMsg = [];

        // お名前メッセージ取得
        $errorMsg['name1'] = $this->checkText($values['name1'], CHECK_NUMBER_DIGIT_255, 'お名前：姓');
        $errorMsg['name2'] = $this->checkText($values['name2'], CHECK_NUMBER_DIGIT_255, 'お名前：名');

        // フリガナメッセージ取得
        $errorMsg['kana1'] = $this->checkKana($values['kana1'], CHECK_NUMBER_DIGIT_255, 'フリガナ：セイ');
        $errorMsg['kana2'] = $this->checkKana($values['kana2'], CHECK_NUMBER_DIGIT_255, 'フリガナ：メイ');

        // 性別メッセージ取得
        if (isset($values['sex'])) {
            $errorMsg['sex'] = $this->checkRadio($values['sex'], SEX_LIST, '性別');
        } elseif (!isset($values['sex'])) {
            $errorMsg['sex'] = $this->checkRadio("", SEX_LIST, '性別');
        }

        // 年齢メッセージ取得
        $errorMsg['age'] = $this->checkSelect($values['age'], AGE_LIST, '年齢');

        // 血液型メッセージ取得
        if (isset($values['blood_type'])) {
            $errorMsg['blood_type'] = $this->checkRadio($values['blood_type'], BLOOD_LIST, '血液型');
        } elseif (!isset($blood_type)) {
            $errorMsg['blood_type'] = $this->checkRadio("", BLOOD_LIST, '血液型');
        }

        // 職業メッセージ取得
        $errorMsg['job'] = $this->checkSelect($values['job'], JOB_LIST, '職業');

        // 郵便番号（上下）チェック後の結果、msg振り分け
        $errorMsg['zip1'] = $this->checkNum($values['zip1'], CHECK_NUMBER_DIGIT_3, '郵便番号上');
        $errorMsg['zip2'] = $this->checkNum($values['zip2'], CHECK_NUMBER_DIGIT_4, '郵便番号下');

        // 都道府県メッセージ取得
        $errorMsg['address1'] = $this->checkSelect($values['address1'], PREFUCTURES_LIST, '都道府県');

        // 住所メッセージ取得
        $errorMsg['address2'] = $this->checkText($values['address2'], CHECK_NUMBER_DIGIT_255, '住所');

        // ビル・マンションメッセージ取得
        $errorMsg['address3'] = $this->checkAddress3($values['address3'], CHECK_NUMBER_DIGIT_255, 'ビル・マンション名');

        // 電話番号（1,2,3）チェック後の結果、msg振り分け
        $errorMsg['tel1'] = $this->checkNum($values['tel1'], CHECK_NUMBER_DIGIT_5, '電話番号1');
        $errorMsg['tel2'] = $this->checkNum($values['tel2'], CHECK_NUMBER_DIGIT_4, '電話番号2');
        $errorMsg['tel3'] = $this->checkNum($values['tel3'], CHECK_NUMBER_DIGIT_4, '電話番号3');

        // メールメッセージ取得
        $errorMsg['mail'] = $this->checkMail($values['mail'], CHECK_NUMBER_DIGIT_255, 'メールアドレス');
        $errorMsg['mail2'] = $this->checkMail2($values['mail'], $values['mail2'], 'メールアドレス2');

        // カテゴリーメッセージ取得
        if (isset($values['category'])) {
            $errorMsg['category'] = $this->checkCategory($values['category'], CATEGORY_LIST);
        }

        // お問い合わせメッセージ取得
        $errorMsg['info'] = $this->checkInfo($values['info'], 'お問い合わせ内容');

        return $errorMsg;
    }

    /**
     * 入力チェック
     *
     * @param array $values 入力値
     * 
     * @return void
     */
    public function checkInputData(array $values)
    {
        $this->errorMsg = $this->checkAll($values); //エラーメッセージ取得
        $this->result = $this->msgCheck($this->errorMsg);
    }

    /**
     * バリデーション後の結果を取得
     *
     * @return void
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * バリデーション後のエラーメッセージ取得
     *
     * @return array|null
     */
    public function getErrorMsgs()
    {
        return $this->errorMsg;
    }
}
