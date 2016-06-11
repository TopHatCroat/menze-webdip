<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));


$messages = array();

if(isset($_GET['session']) && !empty($_GET['session'])){
    $admin = User::findBySessionToken($_GET['session']);
    if($admin != null && UserHelper::isAdmin($admin)){
        $messages["admin"] = $admin->toArray();
    } else {
        $messages["error"] = "Greška u sustavu";
    }
} else {
    $messages["error"] = "Greška u sustavu";
}

if(isset($_GET['time']) && !empty($_GET['time'])){
    Settings::setTime($_GET['time']);
    $messages["time"] = Settings::getTime();
    
}


if(count($messages) != 0){
    echo json_encode($messages);
}





