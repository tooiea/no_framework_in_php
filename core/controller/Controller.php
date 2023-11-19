<?php

class Controller {
    /**
     * セッション開始
     */
    public function __construct()
    {
        session_start();
        session_regenerate_id();
    }
}