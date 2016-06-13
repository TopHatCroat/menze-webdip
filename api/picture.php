<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));
$json = array();
if(isset($_POST['newPicture'])) {
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['title'])) {
            $json['errors'][] = "Naslov sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Naslov mora biti unesen";

    if (isset($_POST['tags']) && !empty($_POST['tags'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['tags'])) {
            $json['errors'][] = "Oznake sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Oznake moraju biti unesene";


    if (!isset($json["errors"])) {
        $newPicture = new Picture();

        if(isset($_FILES['image'])){
            $imageName = explode(".", $_FILES['image']['name']);
            $extension = end($imageName);
            $imagePath = "../public/img/upload/"  . $_POST['title'] . Settings::getTime() . "." . $extension;
            $imagePath = str_replace(" ", "", $imagePath);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $newPicture->setPath($imagePath);
            } else $json['errors'] = "Neuspjelo spremanje slike";
        }

        $newPicture->setTitle($_POST["title"]);
        $newPicture->setTags($_POST["tags"]);

        $user = Session::getLoggedInUser();
        if($user != null){
            $newPicture->setUser($user->getId());
        } else {
            $json['errors'] = "Korisnik nije prijavljen";
        }
        
        $newPicture->setDailyMenu($_POST["dailyMenu"]);
        
        if (!isset($json["errors"])) {
            $newPicture->save();
            $json["success"] = "Uspješno dodana nova slika";
        }
    }

    header( "Location: picture.php" );
    echo json_encode($json);
    die();
}

//restaurant.php?

$user = Session::getLoggedInUser();
if(isset($_GET['skip'])) $pictures = Picture::findByUser($user->getId(), $_GET['skip']);
else $pictures = Picture::findByUser($user->getId(), null);

foreach ($pictures as $r){
    $dailyMenu = DailyMenu::findById($r->getDailyMenu());
    $restaurant = Restaurant::findById($dailyMenu->getRestaurant());
    
    $data = $r->toArray();
    $data["dailyMenu"] = $dailyMenu->getType();
    $data["restaurant"] = $restaurant->getName();
    $json[] = $data;
}

echo json_encode($json);
