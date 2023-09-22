<?php

class BaseValidator {

    /**
     * エラーメッセージが含まれているかをチェック
     * 
     * @param  array $errorMsg エラーメッセージの配列
     * @return bool メッセージがあればtrue
     */
    public function msgCheck(array $errorMsg)
    {
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
     * nullチェック
     * 
     * @param  mixed $value formで入力された値
     * @return bool データがない場合true
     */
    public function isEmpty(mixed $value)
    {
        if (is_null($value)) {
            return true;
        } else {
            if ("" == $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * 存在チェック
     * 
     * @param  int $value formで入力されたキー
     * @param  array $list チェックするリスト
     * @return bool データがない場合true
     */
    public function isValueInList(int $value, array $list)
    {
        if (array_key_exists($value, $list)) {
            return false;
        }
        return true;
    }

    /**
     * 存在チェック（array）
     * 
     * @param  array $value formで入力されたキーの配列
     * @param  array $list チェックするリスト
     * @return bool
     */
    public function isValueInListArray(array $value, array $list)
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
     * @param  string $value formで入力された文字列
     * @return bool 判定と変換後の文字列
     */
    public function checkFullKana(string $value)
    {
        $pattern = '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u';
        $result = true;

        if (preg_match($pattern, $value)) {
            $result = false;
        }
        return $result;
    }

    /**
     * 半角→全角変換,半角チェック（数値）
     * 
     * @param  int $value formで入力された数字
     * @return bool 判定と変換後の文字列
     */
    public function checkHalfNum(int $value)
    {
        if (preg_match('/^[0-9]+$/', $value)) {
            return false;
        }
        return true;
    }

    /**
     * select 未選択チェック
     * 
     * @param  int $value formで入力された値（未選択の場合）
     * @return bool
     */
    public function isUnselect(int $value)
    {
        if ("未選択" == $value) {
            return true;
        }
        return false;
    }

    /**
     * 桁数チェック（共通）
     * 
     * @param  string $value formで入力された文字列
     * @param  int $num 桁数チェック用の値
     * @return bool
     */
    public function checkDigitStr(string $value, int $num)
    {
        if (mb_strlen($value) > $num) {
            return true;
        }
        return false;
    }

    /**
     * テキスト [nullチェック＋桁チェック]のみ
     * 
     * @param  string $value formで入力された文字列
     * @param  int $num 桁数チェック用の値
     * @param  string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkText(string $value, int $num, string $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を入力してください";
        } elseif ($this->checkDigitStr($value, $num)) {
            return $name . "を正しく入力してください";
        }
        return "";
    }

    /**
     * フリガナチェック
     * 
     * @param  string $value formで入力された文字列
     * @param  int $num 桁数チェック用の値
     * @param  string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkKana(string $value, int $num, string $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を入力してください。";
        } else if ($this->checkDigitStr($value, $num)) {
            return $name . "を正しく入力してください。";
        } else if ($this->checkFullKana($value)) {
            return $name . "を正しく入力してください。";
        }
        return "";
    }

    /**
     * ラジオボタン共通チェック
     * 
     * @param  int $value formで入力されたキー
     * @param  array $list チェック用のリスト
     * @param  string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkRadio(int $value, array $list, string $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を選択してください。";
        } else if ($this->isValueInList($value, $list)) {
            return "画面から選択してください。";
        }
        return "";
    }

    /**
     * select共通チェック
     * 
     * @param  int $value formで入力されたキー
     * @param  array $list チェック用のリスト
     * @param  string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkSelect(int $value, array $list, string $name)
    {
        if ($this->isUnselect($value)) {
            return $name . "を選択してください。";
        } else if ($this->isValueInList($value, $list)) {
            return "画面から選択してください";
        }
        return "";
    }

    /**
     * 郵便番号, 電話番号チェック
     * 
     * @param int $value formで入力された数字
     * @param int $num 桁数チェック用の値
     * @param string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkNum(int $value, int $num, string $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を入力してください。";
        } else if ($this->checkHalfNum($value)) {
            return $name . 'を正しく入力してください。';
        } else if ($this->checkDigitStr($value, $num)) {
            return $name . 'を正しく入力してください。';
        }
        return "";
    }

    /**
     * ビル/マンション名チェック
     * 
     * @param string $value formで入力されたキー
     * @param int $num 桁数チェック用の値
     * @param string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkAddress3(string $value, int $num, string $name)
    {
        if ($this->checkDigitStr($value, $num)) {
            return $name . "を正しく入力してください。";
        }
        return "";
    }

    /**
     * メールアドレスチェック
     * 
     * @param string $value formで入力されたキー
     * @param int $num 桁数チェック用の値
     * @param string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkMail(string $value, int $num, string $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を入力してください。";
        } else if ($this->checkDigitStr($value, $num)) {
            return  $name . "を正しく入力してください。";
        } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $name . "を正しく入力してください。";
        }
        return "";
    }

    /**
     * メールアドレス2チェック
     * 
     * @param  string $value メールアドレス1
     * @param  string $value2 メールアドレス2（再入力用）
     * @param  string $name 項目名
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
     * @param  array $value formで入力されたキー
     * @param  array $list チェック用のリスト
     * @return string エラーメッセージ
     */
    public function checkCategory(array $values, array $list)
    {
        $msg = "";
        if ($this->isValueInListArray($values, $list)) {
            $msg = "画面から選択してください";
        }
        return $msg;
    }

    /**
     * コメントチェック
     * 
     * @param  string $value formで入力されたキー
     * @param  string $name 項目名
     * @return string エラーメッセージ
     */
    public function checkInfo($value, $name)
    {
        if ($this->isEmpty($value)) {
            return $name . "を入力してください";
        }
        return "";
    }
}