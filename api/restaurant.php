<?php
include_once('../app/app.php');
$errors = array();
//restaurant.php [POST: new]
if(isset($_POST['new']) && !empty($_POST['new'])) {
    if(isset($_POST['name']) && !empty($_POST['name'])){
        if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['name'])){
            $errors['name'] = "Korisničko sadrži nedozvoljene znakove";
        }
    } else $errors['name'] = "Ime restorana mora biti uneseno";

    if(isset($_POST['email']) && !empty($_POST['email'])){
        if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['email'])){
            $errors['email'] = "Email sadrži nedozvoljene znakove";
        }
        if(!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['email'])){
            $errors['email2'] = "Email nije ispravnog formata";
        }
    } else $errors['email'] = "Ime restorana mora biti uneseno";


    if(isset($_POST['address']) && !empty($_POST['address'])){
        if(preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['address'])){
            $errors['address'] = "Adresa sadrži nedozvoljene znakove";
        }
    } else $errors['address'] = "Adresa restorana mora biti unesena";

    if(count($errors) == 0) {
        $newRestaurant = new Restaurant();

        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $imageName = explode(".", $_FILES['image']['name']);
            $extension = end($imageName);
            $imagePath = "../public/img/profile/" . $_POST['name'] . time() . "." . $extension;
            $imagePath = str_replace(" ", "", $imagePath);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $newRestaurant->setImage($imagePath);
            } else $errors['image2'] = "Neuspjelo spremanje slike";
        }

        $newRestaurant->setName($_POST["name"]);
        $newRestaurant->setAddress($_POST["address"]);
        $newRestaurant->setEmail($_POST["email"]);
        $newRestaurant->setCity($_POST["city"]);
        
        if (count($errors) == 0) $newRestaurant->save();
        $errors["success"] = "Uspješno kreiran novi restoran";
    }
    echo json_encode($errors);
    die();
}



$json = array();

//FOR EDITING RESTAURANTS
//restaurant.php?id=[restaurantId]
if(isset($_GET['id']) && !empty($_GET['id'])){
    $editRestaurant = Restaurant::findById($_GET['id']);
    if($editRestaurant != null){
        $user = Session::getLoggedInUser();
        if(UserHelper::hasRight($user, $editRestaurant)){
            //user has right to edit restaurant
            $json["admin"] = $user->toArray();
        }
        //restoraunt found
        $json["restaurant"] = $editRestaurant->toArray();

        $menus = Menu::findByRestaurant($editRestaurant->getId());
        foreach ($menus as $m) {
            $json["restaurant"]["menus"][] = $m->toArray();
        }


    } else {
        $json["error"] = "Restoran ne postoji";
    }
    echo json_encode($json);
    die();
}

//restaurant.php?
$restaurants = Restaurant::all();

foreach ($restaurants as $r){
    $json[] = $r->toArray();
}

echo json_encode($json);
?>