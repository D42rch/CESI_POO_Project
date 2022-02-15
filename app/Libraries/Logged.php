<?php
namespace App\Libraries;

class Logged {

    public static function isConnected($user){
        if($user == null){
            return true;
        }
    }
}