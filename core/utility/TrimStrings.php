<?php

class TrimStrings {
    // 半角、全角のホワイトスペースを削除
    public static function trimWhiteSpace($value)
    {
        $trimedValue = preg_replace("/( |　)/", "", $value);
        return $trimedValue;
    }
}