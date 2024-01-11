<?php

require_once dirname(__FILE__) . '/../const/common_const.php';

class AppModeController
{

    /**
     * 開発時のモード
     *
     * @var string
     */
    private $appMode = MODE;

    /**
     * モードを切り替える場合に設定値を渡す
     *
     * @param string $mode
     */
    public function __construct(string $mode = null)
    {
        if (!is_null($mode) && is_string($mode) && $mode == ('DEV' || 'PRODUCTION')) {
            $this->appMode = $mode;
        }
    }

    /**
     * モードの取得
     *
     * @return string
     */
    public function getAppMode()
    {
        return $this->appMode;
    }
}
