<?php

include_once('../app/app.php');
$json = array();
$time = 0;

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
            var_dump($newReservation);
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
    if (isset($_POST['timeDate']) && !empty($_POST['timeDate'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['title'])) {
            $json['errors'][] = "Vrijeme i datum sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Vrijeme i datum mora biti unesen";

    if (count($json['errors']) == 0) {
        $editReservation = Reservation::findById($_POST['id']);
        if($editReservation != null) {
            if(!empty($_POST["accepted"])) $newReservation->setAccepted($_POST["accepted"]);
            if(!empty($_POST["completed"])) $newReservation->setCompleted($_POST["completed"]);
            if(!empty($_POST["acceptedMessage"])) $newReservation->setAcceptedMessage($_POST["acceptedMessage"]);
            if(!empty($_POST["completedMessage"])) $newReservation->setCompletedMessage($_POST["completedMessage"]);

            $newReservation->save();
            $json["success"][] = "Uspješno izmjenjena rezervacija";
        }

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
