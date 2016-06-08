<?php
include_once('../app/app.php');
$errors = array();
$success = array();

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
        $success["logout"] = "Uspješno ste se odjavili sa sustava";
    }
    json_encode($success);
    die();
}

if(isset($_GET['activation']) && !empty($_GET['activation'])){
    $user = User::findByActivationToken($_GET['activation']);
    $messages = array();
    if($user != null){
        $user->setActive(1);
        $user->setActivationToken("-1");
        $user->save();
        $messages["success"] = "Uspješno ste aktivirali svoj račun";
    } else{
        $messages["error"] = "Korisnik nije pronađen ili je aktivacijski link neispravan";
    }
    echo json_encode($messages);
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
        if($user->getActive() != "1"){
            $errors['active'] = "Korisnički račun još nije aktiviran, molimo vas da aktivirate vaš račun pomoću linka u email-u";
        } else {
            Session::logInUser($user);
            if(isset($_POST['remember']) && $_POST['remember'] == "on"){
                UserHelper::rememberUser($user);
            }
            $success["success"] = "Uspješno ste prijavljeni u sustav";
        }
    } else {
        $errors['pass'] = "Pogrešno korisničko ime ili lozinka";
    }
}
if(count($errors) == 0) echo json_encode($success);
else echo json_encode($errors);
?>