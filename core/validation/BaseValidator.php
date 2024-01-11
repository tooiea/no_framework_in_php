<?php

/**
 * バリデーションの基底クラス
 */
class BaseValidator
{

    /**
     * エラーメッセージが含まれているかをチェック
     *
     * @param array $errorMsg エラーメッセージの配列
     * 
     * @return bool メッセージがあればtrue
     */
    public function msgCheck(array $errorMsg)
    {
        $result = true;
        foreach ($errorMsg as $msg) {
            if (!empty($msg)) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    /**
     * NULLチェック
     *
     * @param mixed $value formで入力された値
     * 
     * @return bool データがない場合true
     */
    public function isEmpty(mixed $value)
    {
        $result = false;
        if (is_null($value)) {
            $result = true;
        } elseif ("" === $value) {
            $result = true;
        }
        return $result;
    }

    /**
     * 存在チェック
     *
     * @param int   $value formで入力されたキー
     * @param array $list  チェックするリスト
     * 
     * @return bool データがない場合true
     */
    public function isValueInList(int $value, array $list)
    {
        $result = false;
        if (array_key_exists($value, $list)) {
            $result = false;
        }
        return $result;
    }

    /**
     * 存在チェック（array）
     *
     * @param array $value formで入力されたキーの配列
     * @param array $list  チェックするリスト
     * 
     * @return bool
     */
    public function isValuesInList(array $value, array $list)
    {
        $result = false;
        foreach ($value as $key => $data) {
            if (!array_key_exists($data, $list)) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    /**
     * 半角カナとひらがな → 全角カナ（文字列）
     * 全角カナ,半角・全角英字を許諾
     *
     * @param string $value formで入力された文字列
     * 
     * @return bool 判定と変換後の文字列
     */
    public function checkRegexKana(string $value)
    {
        $result = false;
        if (!preg_match('/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u', $value)) {
            $result = true;
        }
        return $result;
    }

    /**
     * 半角→全角変換,半角チェック（数値）
     *
     * @param mixed $value formで入力された数字
     * 
     * @return bool 判定と変換後の文字列
     */
    public function checkRegexNum(mixed $value)
    {
        $result = false;
        if (!preg_match('/^[0-9]+$/', $value)) {
            $result = true;
        }
        return $result;
    }

    /**
     * セレクトボックス未選択チェック
     *
     * @param mixed $value formで入力された値（未選択の場合）
     * 
     * @return bool
     */
    public function isUnselect(mixed $value)
    {
        $result = false;
        if ("未選択" === $value) {
            $result = true;
        }
        return $result;
    }

    /**
     * 桁数チェック（共通）
     *
     * @param mixed $value formで入力された文字列
     * @param int   $num   桁数チェック用の値
     * 
     * @return bool
     */
    public function checkMaxDigit(mixed $value, int $num)
    {
        $result = false;
        if (mb_strlen($value) > $num) {
            $result = true;
        }
        return $result;
    }

    /**
     * テキスト [nullチェック＋桁チェック]のみ
     *
     * @param mixed  $value formで入力された文字列
     * @param int    $num   桁数チェック用の値
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkText(mixed $value, int $num, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を入力してください";
        } elseif ($this->checkMaxDigit($value, $num)) {
            $msg = $name . "を正しく入力してください";
        }
        return $msg;
    }

    /**
     * フリガナチェック
     *
     * @param string $value formで入力された文字列
     * @param int    $num   桁数チェック用の値
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkKana(string $value, int $num, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を入力してください。";
        } elseif ($this->checkMaxDigit($value, $num)) {
            $msg = $name . "を正しく入力してください。";
        } elseif ($this->checkRegexKana($value)) {
            $msg = $name . "を正しく入力してください。";
        }
        return $msg;
    }

    /**
     * ラジオボタン共通チェック
     *
     * @param mixed  $value formで入力されたキー
     * @param array  $list  チェック用のリスト
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkRadio(mixed $value, array $list, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を選択してください。";
        } elseif ($this->isValueInList($value, $list)) {
            $msg = "画面から選択してください。";
        }
        return $msg;
    }

    /**
     * 選択項目のチェック
     * 未選択、リスト外のチェック
     *
     * @param mixed  $value formで入力されたキー
     * @param array  $list  チェック用のリスト
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkSelect(mixed $value, array $list, string $name)
    {
        $msg = "";
        if ($this->isUnselect($value)) {
            $msg = $name . "を選択してください。";
        } elseif ($this->isValueInList($value, $list)) {
            $msg = "画面から選択してください";
        }
        return $msg;
    }

    /**
     * 郵便番号, 電話番号チェック
     *
     * @param mixed  $value formで入力された数字
     * @param int    $num   桁数チェック用の値
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkNum(mixed $value, int $num, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を入力してください。";
        } elseif ($this->checkRegexNum($value)) {
            $msg = $name . 'を正しく入力してください。';
        } elseif ($this->checkMaxDigit($value, $num)) {
            $msg = $name . 'を正しく入力してください。';
        }
        return $msg;
    }

    /**
     * ビル/マンション名チェック
     *
     * @param string $value formで入力されたキー
     * @param int    $num   桁数チェック用の値
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkAddress3(string $value, int $num, string $name)
    {
        $msg = "";
        if ($this->checkMaxDigit($value, $num)) {
            $msg = $name . "を正しく入力してください。";
        }
        return $msg;
    }

    /**
     * メールアドレスチェック
     *
     * @param string $value formで入力されたキー
     * @param int    $num   桁数チェック用の値
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkMail(string $value, int $num, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を入力してください。";
        } elseif ($this->checkMaxDigit($value, $num)) {
            $msg = $name . "を正しく入力してください。";
        } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $msg = $name . "を正しく入力してください。";
        }
        return $msg;
    }

    /**
     * メールアドレス2チェック
     *
     * @param string $value  メールアドレス1
     * @param string $value2 メールアドレス2（再入力用）
     * @param string $name   項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkMail2(string $value, string $value2, string $name)
    {
        $msg = "";
        if ($this->isEmpty($value2)) {
            $msg = $name . "を入力してください。";
        } elseif ($value !== $value2) {
            $msg = "メールアドレスが不一致です。";
        }
        return $msg;
    }

    /**
     * カテゴリーチェック
     *
     * @param array $values 入力値
     * @param array $list   比較する配列
     * 
     * @return string エラーメッセージ
     */
    public function checkCategory(array $values, array $list)
    {
        $msg = "";
        if ($this->isValuesInList($values, $list)) {
            $msg = "画面から選択してください";
        }
        return $msg;
    }

    /**
     * コメントチェック
     *
     * @param string $value formで入力されたキー
     * @param string $name  項目名
     * 
     * @return string エラーメッセージ
     */
    public function checkInfo($value, $name)
    {
        $msg = "";
        if ($this->isEmpty($value)) {
            $msg = $name . "を入力してください";
        }
        return $msg;
    }
}
