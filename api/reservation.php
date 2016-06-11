<?php
include_once('../app/app.php');
$json = array();
$time = 0;
Utils::logActivity(basename(__FILE__));


var_dump($_POST);
// reservation.php/
if(isset($_POST['newReservation'])) {
    if (isset($_POST['dateTime']) && !empty($_POST['dateTime'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['dateTime'])) {
            $json['errors'][] = "Vrijeme i datum sadrži nedozvoljene znakove";
        }

        if (strtotime($_POST['dateTime']) === false) {
            $json['errors'][] = "Vrijeme i datum nije ispravnog formata";
        } else {
            $time = strtotime($_POST['dateTime']);
        }
    } else $json['errors'][] = "Vrijeme i datum mora biti unesen";

    if (!isset($json['errors'])) {
        $newReservation = new Reservation();

        $user = Session::getLoggedInUser();
        if($user != null){
            $newReservation->setReservedAt($time);
            $newReservation->setRestaurant($_POST["restaurant"]);
            $newReservation->setUser($user->getId());
            $newReservation->setAccepted(0);
            $newReservation->setCompleted(0);
            $newReservation->setAcceptedMessage('');
            $newReservation->setCompletedMessage('');
            $newReservation->save();
            $json["success"][] = "Uspješno napravljena rezervacija";
        } else {
            $json['errors'][] = "Korisnik nije prijavljen";
        }

    }

    echo json_encode($json);
}
// reservation.php/
if(isset($_POST['editReservation'])) {

    $editReservation = Reservation::findById($_POST['editReservation']);
    if($editReservation != null) {
        if(isset($_POST["accepted"])) $editReservation->setAccepted(1);
        if(isset($_POST["completed"])) $editReservation->setCompleted(1);
        if(!empty($_POST["acceptedMessage"])) $editReservation->setAcceptedMessage($_POST["acceptedMessage"]);
        if(!empty($_POST["completedMessage"])) $editReservation->setCompletedMessage($_POST["completedMessage"]);

        $editReservation->save();
        $json["success"][] = "Uspješno izmjenjena rezervacija";
    } else $json['errors'][] = "Rezervacija nije pronađena";



    echo json_encode($json);
    die();
}

//FOR GETTING RESERVATIONS BY RESTAURANT
//reservation.php?restaurant=[restaurantId]
if(isset($_GET['restaurant']) && !empty($_GET['restaurant'])){
    $reservations = Reservation::findByRestaurant($_GET['restaurant']);
    
    if($reservations != null){
        foreach ($reservations as $r) {
            $json["reservations"][] = $m->toArray();
        }
    } else {
        $json["errors"][] = "Nema rezervacija";
    }
    echo json_encode($json);
    die();
}


//FOR GETTING RESERVATIONS BY USER
//reservation.php?user=[userId]
if(isset($_GET['user']) && !empty($_GET['user'])){
    $reservations = Reservation::findByUser($_GET['user']);

    if($reservations != null){
        foreach ($reservations as $r) {
            $json["reservations"][] = $m->toArray();
        }
    } else {
        $json["errors"][] = "Nema rezervacija";
    }
    echo json_encode($json);
    die();
}
