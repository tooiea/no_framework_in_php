<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once dirname(__FILE__) . '/../../../controller/form/InputController.php';
require_once dirname(__FILE__) . '/../data/formData.php';

class BaseModel extends TestCase {
    /**
     * @var クラスインスタンス
     */
    protected $instance;

    /**
     * コントローラ内の関数を実行する前にセット
     *
     * @return void
     */
    public static function setUpBefore(): void
    {
        // warningもエラーとして出力する
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $msg  = 'Error #' . $errno . ': ';
            $msg .= $errstr . " on line " . $errline . " in file " . $errfile;
            throw new RuntimeException($msg);
        });
    }
}