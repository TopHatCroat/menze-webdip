<?php
include_once('../app/app.php');

$errors = array();

if(isset($_POST['username']) && !empty($_POST['username'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['username'])){
        $errors['username'] = "Korisničko sadrži nedozvoljene znakove";
    }
    if(UserHelper::checkIfExists('username', $_POST['username']) != '0'){
        $errors['username2'] = "Korisničko ime već postoji";
    };
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
    if(UserHelper::checkIfExists('email', $_POST['email']) != '0'){
        $errors['email2'] = "Već postoji račun sa odabranom e-mail adresom";
    };
} else $errors['email'] = "Email mora biti unesen";

if(isset($_FILES['image']) && count(getimagesize($_FILES['image']['tmp_name'])) != 0){
    if($_FILES['image']['size'] > 50 * 1024){
        $errors['image'] = "Slika mora biti manja od 50 KB";
    }
} else $errors['image'] = "Slika mora biti slika, jer inace nije slika";


if(count($errors) == 0){
    $activationToken = md5($_POST['username'] . $_POST['email'] . time());
    $newUser = new User();

    $imageName = explode(".", $_FILES['image']['name']);
    $extension = end($imageName);
    $imagePath = "../public/img/profile/"  . $_POST['username'] . "." . $extension;
    
    var_dump($imagePath);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        $newUser->setImage($imagePath . $extension);
    } else $errors['image2'] = "Neuspjelo spremanje slike";

    $newUser->setUsername($_POST['username']);
    $newUser->setEmail($_POST['email']);
    $newUser->setPasswordDigest(crypt($_POST['email']));

    if(isset($_POST['name'])) $newUser->setName(isset($_POST['name']));
    if(isset($_POST['surname'])) $newUser->setSurname(isset($_POST['surname']));
    //if(isset($_POST['city'])) $newUser->setCity(isset($_POST['city']));
    if(isset($_POST['address'])) $newUser->setAddress(isset($_POST['address']));

    $newUser->setRole('r1111111111');
    $newUser->setActivationToken($activationToken);
    $newUser->setActive(0);
    $newUser->setDeleted(0);

//    $to = $_POST['email'];
//    $subject = "Aktivacija korisničkog računa";
//    $message = "Za aktivaciju računa na zadaći 04 kliknite <a href='https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x051/api/user.php?activation=" . $activationToken . "'>OVDJE</a>";
//
//    $headers = "MIME-Version: 1.0" . "\r\n"
//        . "Content-type:text/html;charset=UTF-8" . "\r\n"
//        . 'From: <antmartin2@foi.com>' . "\r\n";
//
//    mail($to, $subject, $message, $headers);

    $newUser->save();
}

var_dump($errors);
?>