<?php

class UserHelper{
    const REMEMBER_COOKIE = "rememberToken";
    
    public static function getRememberCookie(){
        if(isset($_COOKIE[self::REMEMBER_COOKIE]) && !empty($_COOKIE[self::REMEMBER_COOKIE])){
            return $_COOKIE[self::REMEMBER_COOKIE];
        } else {
            return null;
        }
    }

    public static function checkIfExists($property, $value){
        if($property == 'username'){
            return Database::count("SELECT COUNT(*) FROM users WHERE username='$value'");
        } else if($property == 'email') {
            return Database::count("SELECT COUNT(*) FROM users WHERE email='$value'");
        } else new Exception("Unsuppored property");
    }
    
    public static function rememberUser($user){
        if(!is_a($user, "User")){
            var_dump($user);
            return false;
        }

        $rememberToken = md5($user->getUsername() . time() + 42);
        $valitUntil = time() + 60 * 60 * 24 * 365 * 20;
        setcookie(self::REMEMBER_COOKIE, $rememberToken, $valitUntil);

        $user->setRememberToken($rememberToken);
        $user->save();
        
        return true;
    }

    public static function forgetUser($user){
        if(!is_a($user, "User")){
            var_dump($user);
            return false;
        }

        $user->setRememberToken('-1');
        setcookie(self::REMEMBER_COOKIE, null, -1);
        $user->save();
        return true;
    }

    public static function isAdmin($user){
        if(!is_a($user, "User")){
            var_dump($user);
            return false;
        }
        if($user->getRole() != "3"){
            return false;
        } else{
            return true;
        }
    }

}

?>