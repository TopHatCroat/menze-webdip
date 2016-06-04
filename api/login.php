<?php
include_once('../app/app.php');
$errors = array();

if(isset($_GET['user']) && !empty($_GET['user'])){
    $user = Session::getLoggedInUser();
    if($user != null){
        echo json_encode($user->toArray());
    }
    die();
}

if(isset($_GET['logout']) && !empty($_GET['logout'])){
    $user = Session::getLoggedInUser();
    if($user != null){
        Session::logOutUser($user);
        UserHelper::forgetUser($user);
    }
    die();
}


if(isset($_POST['username']) && !empty($_POST['username'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['username'])){
        $errors['username'] = "Korisničko sadrži nedozvoljene znakove";
    }
} else $errors['username'] = "Korisničko ime mora biti uneseno";

if(isset($_POST['pass']) && !empty($_POST['pass'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass'])){
        $errors['pass'] = "Lozinka sadrži nedozvoljene znakove";
    }
} else $errors['pass'] = "Lozinka mora biti unesen";


if(count($errors) == 0){
    $user = User::findByCredentials($_POST['username'], $_POST['pass']);
    if($user != null){
        Session::logInUser($user);
        if(isset($_POST['remember']) && $_POST['remember'] == "on"){
            UserHelper::rememberUser($user);
        }
        $str["success"] = "Uspješno ste prijavljeni u sustav";
        echo json_encode($str);
    } else {
        $errors['pass'] = "Pogrešno korisničko ime ili lozinka";
    }
}
if(count($errors) != 0) echo json_encode($errors);
?>