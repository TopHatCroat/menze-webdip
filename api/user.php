<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));

$json = array();

//FOR VIEWING USER
//user.php?id=[userId]
if(isset($_GET['id']) && !empty($_GET['id'])){
    $viewUser = User::findById($_GET['id']);
    if($viewUser != null){
        $user = Session::getLoggedInUser();
        if(UserHelper::hasRight($user, $viewUser)){
            //user has right to edit restaurant
            $json["admin"] = $user->toArray();
        }
    //user found
        $json["user"] = $viewUser->toArray();
        $reservations = Reservation::findByUser($viewUser->getId());
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

if(isset($_POST['editUser']) && !empty($_POST['editUser'])){

    if(!empty($_POST['pass'])){
        if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass'])){
            $json['errors'][] = "Lozinka sadrži nedozvoljene znakove";
        }
    }

    if(!empty($_POST['pass-confirm'])){
        if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass-confirm'])){
            $json['errors'][] = "Provjera lozinke sadrži nedozvoljene znakove";
        }
        if($_POST['pass'] != $_POST['pass-confirm']){
            $json['errors'][] = "Lozinka i provjera lozinke nisu identični";
        }
    }

    if(!empty($_FILES['image']['name']) && count(getimagesize($_FILES['image']['tmp_name'])) != 0){
        if($_FILES['image']['size'] > 50 * 1024){
            $json['errors'][] = "Slika mora biti manja od 50 KB";
        }
    }


    if(!isset($json['errors'])) {
        $editUser = User::findById($_POST['editUser']);

        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $imageName = explode(".", $_FILES['image']['name']);
            $extension = end($imageName);
            $imagePath = "../public/img/profile/" . $_POST['username'] . time() . "." . $extension;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $editUser->setImage($imagePath);
            } else $json['errors'][] = "Neuspjelo spremanje slike";
        }

        if(isset($_POST['pass']) && !empty($_POST['pass'])) $editUser->setPasswordDigest(hash("sha256", $_POST['pass']));

        if (isset($_POST['name']) && !empty($_POST['name'])) $editUser->setName($_POST['name']);
        if (isset($_POST['surname']) && !empty($_POST['surname'])) $editUser->setSurname($_POST['surname']);
        if (isset($_POST['city']) && !empty($_POST['city'])) $editUser->setCity($_POST['city']);
        if (isset($_POST['address']) && !empty($_POST['address'])) $editUser->setAddress($_POST['address']);

        if(isset($_POST['admin'])){
            if (isset($_POST['active'])) $editUser->setActive(1);
            else $editUser->setActive(0);
        }

        if(!isset($json['errors'])) {
            $editUser->save();
            $json['success'][] = "Uspješno ste izmjenili podatke";
        }
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
