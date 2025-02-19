<?php

namespace App\Helpers;

class Utils
{
    public static function dump($variable){
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        die;
    }
}