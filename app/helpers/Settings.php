<?php
class Settings{

    /**
     * @return int timestamp of actual time plus time offset in the database
     */
    public static function getTime(){
        $sql = "SELECT * FROM settings WHERE setting='time'";
        $result = mysqli_fetch_array(Database::query($sql));
        $result = (intval($result["value"]) * 60 * 60 )+ time();
        return $result;
    }

    /**
     * Sets the time offst to specified value
     * @param $time time to set the offset to
     * @return bool
     */
    public static function setTime($time){
        $sql = "UPDATE settings SET value='$time' WHERE setting='time'";
        Database::query($sql);
        return true;
    }
}

?>