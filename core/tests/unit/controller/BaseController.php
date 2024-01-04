<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once dirname(__FILE__) . '/../../../controller/form/InputController.php';
require_once dirname(__FILE__) . '/../data/formData.php';

class BaseController extends TestCase {
    /**
     * @var コントとローラインスタンス
     */
    protected $instance;

    /**
     * コントローラ内の関数を実行する前にセット
     *
     * @param リクエストメソッド $requestMethod
     * @param セッション $session
     * @param ポスト $post
     * @return void
     */
    public function setUpBefore($requestMethod, $session, $post): void
    {
        // warningもエラーとして出力する
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $msg  = 'Error #' . $errno . ': ';
            $msg .= $errstr . " on line " . $errline . " in file " . $errfile;
            throw new RuntimeException($msg);
        });

        // テスト用入力値のセット
        $_SERVER["REQUEST_METHOD"] = $requestMethod;
        $_SESSION = $session;
        $_POST = $post;
    }

    protected function tearDown(): void
    {
        $_SESSION = array();
    }
}