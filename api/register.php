<?php
include_once('../app/app.php');
var_dump($_POST);
var_dump($_FILES);
var_dump(time());

$errors = array();

if(isset($_POST['username']) && !empty($_POST['username'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['username'])){
        $errors['username'] = "Korisničko sadrži nedozvoljene znakove";
    }
    UserHelper::checkIfExists('bla', $_POST['username']);
} else $errors['username'] = "Korisničko ime mora biti uneseno";

if(isset($_POST['pass']) && !empty($_POST['pass'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass'])){
        $errors['pass'] = "Lozinka sadrži nedozvoljene znakove";
    }
} else $errors['pass'] = "Lozinka mora biti unesen";

if(isset($_POST['pass-confirm']) && !empty($_POST['pass-confirm'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass-confirm'])){
        $errors['pass-confirm'] = "Provjera lozinke sadrži nedozvoljene znakove";
    }
    if($_POST['pass'] != $_POST['pass-confirm']){
        $errors['pass-confirm'] = "Lozinka i provjera lozinke nisu identični";
    }
} else $errors['pass-confirm'] = "Provjera lozinke mora biti unesen";

if(isset($_POST['email']) && !empty($_POST['email'])){
    if(!preg_match('/^[\w\._\-]{4,}@[a-zA-Z_]+?\.[a-zA-Z]{2,6}$/', $_POST['email'])){
        $errors['email'] = "Email mora biti ispravan";
    }
} else $errors['email'] = "Email mora biti unesen";

if(isset($_FILES['image']) && getimagesize($_FILES['image']['tmp_name']) == 0){
    if($_FILES['image']['size'] < 50 * 1024){
        $errors['image'] = "Slika mora biti manja od 50 KB";
    }
} else $errors['image'] = "Slika mora biti slika, jer inace nije slika";


if(count($errors) == 0){
    $activationToken = md5($_POST['username'] . $_POST['email'] . time());

    $extension = end(explode(".", $_FILES['image']['name']));
    $imgagePath = "/public/img/profile/"  . $_POST['username'] . $extension;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {

    } else $errors['image2'] = "Slika mora biti slika, jer inace nije slika";
}
?>