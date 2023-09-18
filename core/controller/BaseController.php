<?php

class BaseController {

    /**
     * 名前連結処理
     *
     * @param  string $value
     * @param  string $value2
     * @return string
     */
    public function concatName($value, $value2)
    {
        return $value . '　' . $value2;
    }

    /**
     * 文字列としてそのまま連結
     *
     * @param  string $value
     * @param  string $value2
     * @param  string $value3
     * @return string
     */
    public function concatString($value, $value2, $value3 = null)
    {
        return $value . $value2 . $value3;
    }

    /**
     * 電話番号として連結
     *
     * @param  string $value1
     * @param  string $value2
     * @param  string $value3
     * @return string
     */
    public function concatTel($value1, $value2, $value3) {
        $data = $value1 . '-' . $value2 . '-' . $value3;
        return $data;
    }

    /**
     * 郵便局番号として連結
     *
     * @param  string $value1
     * @param  string $value2
     * @return string
     */
    public function concatZipNum($value1, $value2) {
        $data = $value1 . '-' . $value2;
        return $data;
    }
}