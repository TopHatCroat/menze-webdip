<?php

class UserHelper{
    const COOKIE_NAME = "rememberToken";
    
    public static function getRememberCookie(){
        if(isset($_COOKIE[COOKIE_NAME]) && !empty($_COOKIE[COOKIE_NAME])){
            return $_COOKIE[COOKIE_NAME];
        } else {
            return null;
        }
    }
}

?>