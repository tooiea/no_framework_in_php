<?php
require_once(dirname(__FILE__) . '/../const/data.php'); //リスト読み込み


//共通パーツ

/** 
 * クロスサイトスクリプティング
 * @param array $values formで入力された配列
 * @return array $values　エンコード後の配列
 */
function changeEncode($values) {
    foreach ($values as $key => $data) {
        if (isset($values['category']) && $values['category']) {
            foreach ($values['category'] as $ckey => $cvalue) {
                $cvalue[$ckey] = htmlspecialchars($cvalue, ENT_QUOTES, "UTF-8");
            }
        } else {
            $values[$key] = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
        }
    }
    return $values;
}

/** 
 * nullチェック（共通）
 * @param string $value formで入力された値
 * @return bool データがない場合true
 */
function isEmpty($value)
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
 * @param int $value formで入力されたキー
 * @param array $list チェックするリスト
 * @return bool データがない場合true
 */
function isValueInList($value, $list)
{
    if (array_key_exists($value, $list)) {
        return false;
    }
    return true;
}

/** 
 * 存在チェック（array）
 * @param array $value formで入力されたキーの配列
 * @param array $list チェックするリスト
 * @return bool
 */
function isValueInListArray($value, $list)
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
 * @param string $value formで入力された文字列
 * @return array 判定と変換後の文字列
 */
function checkFullKana($value)
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
 * @param int $value formで入力された数字
 * @return array 判定と変換後の文字列
 */
function checkHalfNum($value)
{
    if (preg_match('/^[0-9]+$/', $value)) {
        return false;
    }
    return true;
}

/** 
 * select 未選択チェック
 * @param int $value formで入力された値（未選択の場合）
 * @return array 判定[0] 変換後の文字列[1] 
 */
function isUnselect($value)
{
    if ("未選択" == $value) {
        return true;
    }
    return false;
}

/** 
 * 桁数チェック（共通）
 * @param string $value formで入力された文字列
 * @param int $num 桁数チェック用の値
 * @return bool
 */
function checkDigitStr($value, $num) {
    if (mb_strlen($value) > $num) {
        return true;
    }
    return false;
}

//個別

/** 
 * テキスト [nullチェック＋桁チェック]のみ
 * @param string $value formで入力された文字列
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ
 */
function checkText($value, $num, $name) {
    if (isEmpty($value)) {
        return $name . "を入力してください";
    } else {
        if (checkDigitStr($value, $num)) {
            return $name . "を正しく入力してください";
        }
    }
    return "";
}

/** 
 * フリガナチェック
 * @param string $value formで入力された文字列
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkKana($value, $num, $name)
{
     if (isEmpty($value)) {
        return $name . "を入力してください。";
    } else if (checkDigitStr($value, $num)) {
        return $name . "を正しく入力してください。";
    } else if (checkFullKana($value)) {
        return $name . "を正しく入力してください。";
    }
    return "";
}

/** 
 * ラジオボタン共通チェック
 * @param int $value formで入力されたキー
 * @param array $list チェック用のリスト
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkRadio($value, $list, $name) {
    if (isEmpty($value)) {
        return $name . "を選択してください。";
    } else if (isValueInList($value, $list)) {
        return "画面から選択してください。";
    }
    return "";
}

/** 
 * select共通チェック
 * @param int $value formで入力されたキー
 * @param array $list チェック用のリスト
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkSelect($value, $list, $name) {
    if (isUnselect($value)) {
        return $name . "を選択してください。";
    } else if (isValueInList($value, $list)) {
        return "画面から選択してください";
    }
    return "";
}
/**
 * フリガナ、数値変換
 * @param array formで入力された配列
 * @return array 変換後の配列
 */
function convertStr($values) {
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

/** 
 * 郵便番号, 電話番号チェック
 * @param int $value formで入力された数字
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkNum($value, $num, $name)
{
    if (isEmpty($value)) {
        return $name . "を入力してください。";
    } else if (checkHalfNum($value)) {
        return $name . 'を正しく入力してください。';
    } else if (checkDigitStr($value, $num)) {
        return $name . 'を正しく入力してください。';
    }
    return "";
}

/** 
 * ビル/マンション名チェック
 * @param string $value formで入力されたキー
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkAddress3($value, $num, $name)
{
    if (checkDigitStr($value, $num)) {
        return $name . "を正しく入力してください。";
    }
    return "";
}

/** 
 * メールアドレスチェック
 * @param string $value formで入力されたキー
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ 
 */
function checkMail($value, $num, $name)
{
    if (isEmpty($value)) {
        return $name . "を入力してください。";
    } else if (checkDigitStr($value, $num)) {
        return  $name . "を正しく入力してください。";
    } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return $name . "を正しく入力してください。";
    }
    return "";
}

/** 
 * メールアドレス2チェック
 * @param string $value メールアドレス1
 * @param string $value2 メールアドレス2（再入力用）
 * @param int $num 桁数チェック用の値
 * @param string $name 項目名
 * @return string エラーメッセージ
 */
function checkMail2($value, $value2, $name)
{
    $str = "";
    if (isEmpty($value2)) {
        $str = $name . "を入力してください。";
    } else if ($value != $value2) {
        $str = "メールアドレスが不一致です。";
    }
    return $str;
}

/** 
 * カテゴリーチェック
 * @param int $value formで入力されたキー
 * @param array $list チェック用のリスト
 * @return string エラーメッセージ
 */
function checkCategory($value, $list)
{
    if (empty($value)) {
        return "";
    } else if (isValueInListArray($value, $list)) {
        return "画面から選択してください";
    }
    return "";
}

/** 
 * コメントチェック
 * @param string $value formで入力されたキー
 * @param string $name 項目名
 * @return string エラーメッセージ
 */
function checkInfo($value, $name)
{
    if (isEmpty($value)) {
        return $name . "を入力してください";
    }
    return "";
}