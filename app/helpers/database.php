<?php
class Database {
    const server = "localhost";
    const user = "WebDiP2015x051";
    const password = "admin_Bpds";
    const dbName = "WebDiP2015x051";

    private static $instance;
    private $MYSQLI;

    private function __construct() {
        $this->MYSQLI = @new mysqli(self::server, self::user, self::password, self::dbName);

        if( mysqli_connect_errno() ) {
            var_dump($this->MYSQLI);
            throw new Exception("Error connecting to database.");
        }

        $this->MYSQLI->set_charset("utf8");
    }

    public static function init() {
        if( self::$instance instanceof self ) {
            return false;
        }

        self::$instance = new self();
    }

    public static function getMObj() {
        return self::$instance->MYSQLI;
    }

    public static function query($q) {
        return self::queryLog($q, null);
    }

    public static function queryWithLog($q, $userId) {
        return self::queryLog($q, $userId);
    }

    public static function rawQuery($q) {
        return self::$instance->MYSQLI->query($q);
    }

    public static function escape($string) {
        return self::$instance->MYSQLI->real_escape_string($string);
    }
    
    public static function count($q){
        $result = mysqli_fetch_array(self::$instance->MYSQLI->query($q));
        return $result['COUNT(*)'];
    }

    private static function queryLog($q, $userId) {
        if($userId == null) $sql = "INSERT INTO db_log(query) values('$q')";
        else $sql = "INSERT INTO db_log(query, users_id) values('$q', '$userId')";
        self::rawQuery($sql);
        return self::rawQuery($q);
    }

    public static function logInLog($action, $userId){
        self::rawQuery("INSERT INTO log_in_log(action, users_id) VALUES('$action', '$userId')");
    }
    
    public static function generalLog($action, $userId){
        self::rawQuery("INSERT INTO general_log(action, users_id) VALUES('$action', '$userId')");
    }

}
?>
