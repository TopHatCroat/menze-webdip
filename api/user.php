<?php
include_once('../app/app.php');


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
