<?php

class BaseController {

    public function concatString($value, $value2, $value3 = null)
    {
        return $value . $value2 . $value3;
    }
}