<?php
class Utils{

    public static function paramToString($param){
        if(count($param) != null) {
            return json_encode($param);
        } else return '';
    }

    public function logActivity($action){
        if(self::paramToString($_GET) != '') $action .= '#' . 'GET=' . self::paramToString($_GET);
        if(self::paramToString($_POST) != '') $action .= '#' . 'POST=' . self::paramToString($_POST);
        $user = Session::getLoggedInUser();
        if(is_a($user, "User")){
            Database::generalLog($action, $user->getId());
        } else{
            Database::generalLog($action, 0);
        }
    }
    
}