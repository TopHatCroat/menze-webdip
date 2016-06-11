<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));


$json = array();

//FOR EDITING AND VIEWING USERS
//user.php?id=[userId]
if(isset($_GET['id']) && !empty($_GET['id'])){
    $editUser = User::findById($_GET['id']);
    if($editUser != null){
        $user = Session::getLoggedInUser();
        if(UserHelper::hasRight($user, $editUser)){
            //user has right to edit restaurant
            $json["admin"] = $user->toArray();
        }
    //user found
        $json["user"] = $editUser->toArray();
        $reservations = Reservation::findByUser($editUser->getId());
        $json["reservations"] = array();
        if($reservations != null){
            foreach ($reservations as $r){
                $json["reservations"][] = $r->toArray();
            }
        }
        
    } else {
        $json["error"] = "Korisnik ne postoji";
    }
    echo json_encode($json);
    die();
}

//user.php
$users = User::all();
$json = array();

foreach ($users as $u){
    $json[] = $u->toArray();
}

echo json_encode($json);
