<?php

class Controller {
    /**
     * セッション開始
     */
    public function __construct()
    {
        // セッション開始されてなければ
        if (!isset($_SESSION)) {
            session_start();
            session_regenerate_id();    
        }
    }
}