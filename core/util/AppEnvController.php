<?php
require_once dirname(__FILE__) . '/../const/common_const.php';

class AppEnvController {

    /**
     * 環境でモードを変更する
     *
     * @var string
     */
    private $appEnv = 'local';
    // private $appEnv = 'production';
    // private $appEnv = 'test';

    /**
     * モードを切り替える場合に設定値を渡す
     *
     * @param string $mode
     */
    public function __construct(string $appEnv = null)
    {
        if (!is_null($appEnv) && is_string($appEnv) && $appEnv == ('local' || 'production' || 'test')) {
            $this->appEnv = $appEnv;
        }
    }

    /**
     * モードの取得
     *
     * @return string
     */
    public function getAppEnv()
    {
        return $this->appEnv;
    }
}