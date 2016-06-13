<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));

$json = array();

if(isset($_POST['username']) && !empty($_POST['username'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['username'])){
        $json['errors'][] = "Korisničko sadrži nedozvoljene znakove";
    }
    if(UserHelper::checkIfExists('username', $_POST['username']) != '0'){
        $json['errors'][] = "Korisničko ime već postoji";
    };
} else $json['errors'][] = "Korisničko ime mora biti uneseno";

if(isset($_POST['pass']) && !empty($_POST['pass'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass'])){
        $json['errors'][] = "Lozinka sadrži nedozvoljene znakove";
    }
} else $json['errors'][] = "Lozinka mora biti unesen";

if(isset($_POST['pass-confirm']) && !empty($_POST['pass-confirm'])){
    if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['pass-confirm'])){
        $json['errors'][] = "Provjera lozinke sadrži nedozvoljene znakove";
    }
    if($_POST['pass'] != $_POST['pass-confirm']){
        $json['errors'][] = "Lozinka i provjera lozinke nisu identični";
    }
} else $json['errors'][] = "Provjera lozinke mora biti unesen";

if(isset($_POST['email']) && !empty($_POST['email'])){
    if(!preg_match('/^[\w\._\-]{4,}@[a-zA-Z_]+?\.[a-zA-Z]{2,6}$/', $_POST['email'])){
        $json['errors'][] = "Email mora biti ispravan";
    }
    if(UserHelper::checkIfExists('email', $_POST['email']) != '0'){
        $json['errors'][] = "Već postoji račun sa odabranom e-mail adresom";
    };
} else $json['errors'][] = "Email mora biti unesen";

if(!empty($_FILES['image']['name']) && count(getimagesize($_FILES['image']['tmp_name'])) != 0){
    if($_FILES['image']['size'] > 50 * 1024){
        $json['errors'][] = "Slika mora biti manja od 50 KB";
    }
}


if(count($json) == 0){
    $activationToken = md5($_POST['username'] . $_POST['email'] . time());
    $newUser = new User();

    if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
        $imageName = explode(".", $_FILES['image']['name']);
        $extension = end($imageName);
        $imagePath = "../public/img/profile/"  . $_POST['username'] . time() . "." . $extension;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            $newUser->setImage($imagePath);
        } else $json['errors'][] = "Neuspjelo spremanje slike";
    }


    $newUser->setUsername($_POST['username']);
    $newUser->setEmail($_POST['email']);
    $newUser->setPasswordDigest(hash("sha256", $_POST['pass']));

    if(isset($_POST['name'])) $newUser->setName($_POST['name']);
    if(isset($_POST['surname'])) $newUser->setSurname($_POST['surname']);
    if(isset($_POST['city'])) $newUser->setCity($_POST['city']);
    if(isset($_POST['address'])) $newUser->setAddress($_POST['address']);

    $newUser->setRole('1');
    $newUser->setActivationToken($activationToken);
    $newUser->setActive(0);
    $newUser->setDeleted(0);

    if(count($json) == 0){
        $to = $_POST['email'];
        $subject = "Aktivacija korisničkog računa";
        $message = "Za aktivaciju računa na Projektu menze kliknite <a href='https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x051/login.php?activation=" . $activationToken . "'>OVDJE</a>";

        $headers = "MIME-Version: 1.0" . "\r\n"
            . "Content-type:text/html;charset=UTF-8" . "\r\n"
            . 'From: <antmartin2@foi.com>' . "\r\n";

        mail($to, $subject, $message, $headers);

        $newUser->save();
        $json['success'][] = "Uspješno registriranje";
    }
}
echo json_encode($json)
?>