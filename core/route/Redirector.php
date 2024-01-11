<?php

class Redirector
{

    /**
     * リダイレクト:POST
     *
     * @param string $url 指定リダイレクトURL
     * 
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
     * @param string $url 指定リダイレクトURL
     * 
     * @return void
     */
    public function getRedirectTo($url)
    {
        header("Location: $url");
        exit();
    }
}
