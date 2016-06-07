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
            return false;
        }

        $user->setRememberToken('-1');
        setcookie(self::REMEMBER_COOKIE, null, -1);
        $user->save();
        return true;
    }

    public static function isAdmin($user){
        if(!is_a($user, "User")){
            return false;
        }
        if($user->getRole() != "3"){
            return false;
        } else{
            return true;
        }
    }

    public static function hasRight($user, $item){
        if(!is_a($user, "User")){
            return false;
        }
        if(self::isAdmin($user)) return true;

        if(is_a($item, "User")){
            if($item->getId() == $user->getId()) return true;
            else return false;
        } else if(is_a($item, "Restaurant")){
            $sql = "SELECT * FROM restaurant_moderators WHERE users_id='$user->getId()' and restaurants_id='$item->getId()'";
            $result = Database::count(sql);
        } else return false;

        //TODO: test if this works
    }

}

?>