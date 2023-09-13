<?php

class RouteController {
    
    /**
     * 使用するルーティングを追加
     */
    private const ROUTES = [
        ''
    ];

    /**
     * パスから使用するコントローラを返す
     *
     * @param  string $path
     * @return object controller
     */
    public function getExecController($path)
    {
        self::ROUTES;
    }
}