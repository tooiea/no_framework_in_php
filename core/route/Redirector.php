<?php

class Redirector {
    /**
     * リダイレクト:POST
     *
     * @param  string $url
     * @return void
     */
    public function postRedirectTo($url)
    {
        header("Location: $url", true, 307);
        exit();
    }

    /**
     * リダイレクト:GET
     *
     * @param  string $url
     * @return void
     */
    public function getRedirectTo($url)
    {
        header("Location: $url");
        exit();
    }
}