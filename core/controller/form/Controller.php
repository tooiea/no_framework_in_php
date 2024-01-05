<?php
require_once dirname(__FILE__) . '/../../route/Redirector.php';
require_once dirname(__FILE__) . '/../../util/AppModeController.php';

class Controller {

    protected $redirector;
    protected $appMode;

    /**
     * リダイレクトクラス、開発モードの指定
     *
     * @param Redirector $redirector
     * @param string $mode
     */
    public function __construct(Redirector $redirector, string $mode = null)
    {
        $this->redirector = $redirector;

        // 開発モード指定
        $appMode = new AppModeController($mode);
        $this->appMode = $appMode->getAppMode();
    }

    /**
     * 名前、フリガナの文字連結処理
     * @param  string $num1 名前：性
     * @param  string $num2 名前：名
     * @return string 文字連結処理後
     */
    public function concatenationName(string $num1, string $num2)
    {
        $data = $num1 . '　' . $num2;
        return $data;
    }

    /**
     * 郵便番号の文字連結処理
     * @param  string $num1 郵便番号上
     * @param  string $num2 郵便番号下
     * @return string 文字連結処理後
     */
    public function concatenationZip(string $num1, string $num2)
    {
        $data = $num1 . '-' . $num2;
        return $data;
    }

    /**
     * 電話番号連結処理
     * @param  string $num1 電話番号1
     * @param  string $num2 電話番号2
     * @param  string $num3 電話番号3
     * @return string 文字連結処理後
     */
    public function concatenationTelnum(string $num1, string $num2, string $num3)
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
    public function isInListValue(array $data)
    {
        $keyCheckResult = false;
        foreach ($data as $key => $value) {
            //セッション内に存在していないキーが無いかをチェック
            if (!in_array($key, KEY_LIST)) {
                $keyCheckResult = true;
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
        $keys = [
            'contact_no',
            'page_id',
            'name',
            'kana',
            'mail'
        ];
        $returnValues = [];
        foreach ($values as $key => $value) {
            if (in_array($key, $keys) && !empty($value)) {
                $returnValues[$key] = $value;
            }
        }
        return $returnValues;
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
            $values['zip1'] = mb_convert_kana($values['zip1'], "a");
        }

        if ($values['zip2']) {
            $values['zip2'] = mb_convert_kana($values['zip2'], "a");
        }

        if ($values['tel1']) {
            $values['tel1'] = mb_convert_kana($values['tel1'], "a");
        }

        if ($values['tel2']) {
            $values['tel2'] = mb_convert_kana($values['tel2'], "a");
        }

        if ($values['tel3']) {
            $values['tel3'] = mb_convert_kana($values['tel3'], "a");
        }
        return $values;
    }
}