<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));

if(isset($_GET['time']) && !empty($_GET['time'])){
    $messages["time"] = Settings::getTime();

}

echo json_encode($messages);


