<?php

class BaseValidator {

    /**
     * 空チェック
     *
     * @param  string|array $value
     * @return boolean
     */
    public static function isNotEmpty($value)
    {
        if (empty($value) || is_null($value)) {
            return true;
        }
        return false;
    }

    /**
     * 文字列であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isString($value)
    {
        if (!is_string($value)) {
            return true;
        }
        return false;
    }

    /**
     * 整数であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isInteger($value)
    {
        if (!is_integer($value)) {
            return true;
        }
        return false;
    }

    /**
     * 配列であるか
     *
     * @param  mix $value
     * @return boolean
     */
    public static function isArray($value)
    {
        if (!is_array($value)) {
            return true;
        }
        return false;
    }

}