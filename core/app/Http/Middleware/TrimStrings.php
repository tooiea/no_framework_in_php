<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * 全角カタカナ変換対象
     *
     * @var array
     */
    public $convertToKana = [
        'kana1',
        'kana2'
    ];

    /**
     * 半角数値変換対象
     *
     * @var array
     */
    public $convertToInteger = [
        'zip1',
        'zip2',
        'tel1',
        'tel2',
        'tel3'
    ];

    /**
     * リクエスト前の処理
     * 変換:[カナ、数値]
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        // トリムなし
        if (in_array($key, $this->except, true) || ! is_string($value)) {
            return $value;
        }

        // カナ変換対象
        if (in_array($key, $this->convertToKana)) {
            $value = mb_convert_kana($value, "KCV");
        }

        // 半角数値変換対象
        if (in_array($key, $this->convertToInteger)) {
            $value = mb_convert_kana($value, "n");
        }

        // 前後の半角、全角トリム
        return preg_replace('~^[\s\x{FEFF}\x{200B}]+|[\s\x{FEFF}\x{200B}]+$~u', '', $value) ?? trim($value);
    }
}
