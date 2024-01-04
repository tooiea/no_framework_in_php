<?php

interface ExitHandlerInterface {
    /**
     * exitの実行要否判定(テスト、動作環境を区別するため)
     *
     * @return boolean
     */
    public function shouldExit();
}
