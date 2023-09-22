<?php

class Controller {

    /**
     * 名前、フリガナの文字連結処理
     * @param  int $num1 名前：性
     * @param  int $num2 名前：名
     * @return string 文字連結処理後
     */
    public function concatenationName(int $num1, int $num2)
    {
        $data = $num1 . '　' . $num2;
        return $data;
    }

    /**
     * 郵便番号の文字連結処理
     * @param  int $num1 郵便番号上
     * @param  int $num2 郵便番号下
     * @return string 文字連結処理後
     */
    public function concatenationZip(int $num1, int $num2)
    {
        $data = $num1 . '-' . $num2;
        return $data;
    }

    /**
     * 電話番号連結処理
     * @param  int $num1 電話番号1
     * @param  int $num2 電話番号2
     * @param  int $num3 電話番号3
     * @return string 文字連結処理後
     */
    public function concatenationTelnum(int $num1, int $num2, int $num3)
    {
        $data = $num1 . '-' . $num2 . '-' . $num3;
        return $data;
    }

    /**
     * 都道府県と住所の連結
     * @param string $str1 都道府県
     * @param string $str2 住所
     * @return string 文字連結処理後
     */
    public function concatenationAddress(string $str1, string $str2)
    {
        $data = $str1 . $str2;
        return $data;
    }

    /**
     * リスト以外のキーが存在していないかをチェック
     * @param  array $data セッション
     * @return bool チェックした結果
     */
    public function checkKeyOfSession(array $data)
    {
        $keyCheckResult = true;
        foreach ($data as $key => $value) {
            //セッション内に存在していないキーが無いかをチェック
            if (!in_array($key, KEY_LIST)) {
                $keyCheckResult = false;
                break;
            }
        }
        return $keyCheckResult;
    }

    /**
     * クエリパラメータ内に不要なパラメータが存在した場合削除する
     * @param  array $values クエリパラメータ
     * @return array 必要なキーの配列
     */
    public function removeKey(array $values)
    {
        $removedKeyValues = array();
        foreach ($values as $key => $value) {
            if ('contact_no' === $key || 'page_id' === $key || 'name' === $key || 'kana' === $key || 'mail' === $key) {
                $removedKeyValues[$key] = $value;
            }
        }
        return $removedKeyValues;
    }

    /**
     * フリガナ、数値変換
     * @param  array formで入力された配列
     * @return array 変換後の配列
     */
    public function convertStr(array $values)
    {
        if ($values['kana1']) {
            $values['kana1'] = mb_convert_kana($values['kana1'], "KVC");
        }

        if ($values['kana2']) {
            $values['kana2'] = mb_convert_kana($values['kana2'], "KVC");
        }

        if ($values['zip1']) {
            $values['zip1'] = mb_convert_kana($values['zip1'], "n");
        }

        if ($values['zip2']) {
            $values['zip2'] = mb_convert_kana($values['zip2'], "n");
        }

        if ($values['tel1']) {
            $values['tel1'] = mb_convert_kana($values['tel1'], "n");
        }

        if ($values['tel2']) {
            $values['tel2'] = mb_convert_kana($values['tel2'], "n");
        }

        if ($values['tel3']) {
            $values['tel3'] = mb_convert_kana($values['tel3'], "n");
        }
        return $values;
    }
}