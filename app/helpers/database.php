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
        return self::$instance->MYSQLI->query($q);
    }

    public static function escape($string) {
        return self::$instance->MYSQLI->real_escape_string($string);
    }
    
    public static function count($q){
        var_dump(self::$instance->MYSQLI->query($q));
    }

}
?>
