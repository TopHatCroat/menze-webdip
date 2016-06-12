<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));
$errors = array();
$success = array();

if(isset($_POST['newMenu'])) {
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['title'])) {
            $errors['title'] = "Naslov sadrži nedozvoljene znakove";
        }
    } else $errors['title'] = "Naslov mora biti unesen";

    if (isset($_POST['description']) && !empty($_POST['description'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['description'])) {
            $errors['description'] = "Opis sadrži nedozvoljene znakove";
        }
    } else $errors['description'] = "Opis mora biti unesen";


    if (count($errors) == 0) {
        $newMenu = new Menu();

        if(isset($_FILES['image'])){
            $imageName = explode(".", $_FILES['image']['name']);
            $extension = end($imageName);
            $imagePath = "../public/img/other/"  . $_POST['title'] . Settings::getTime() . "." . $extension;
            $imagePath = str_replace(" ", "", $imagePath);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $newMenu->setImage($imagePath);
            } else $errors['image2'] = "Neuspjelo spremanje slike";
        }

        $newMenu->setTitle($_POST["title"]);
        $newMenu->setDescription($_POST["description"]);
        $newMenu->setRestaurant($_POST["restaurant"]);

        $newMenu->save();
        $success["success"] = "Uspješno dodan novi menu";
    }
    if (count($errors) == 0) echo json_encode($success);
    else echo json_encode($errors);
}


// this is for dropdown menu
// menu.php?restaurantId=[restaurantId]
if(isset($_GET['restaurant'])){
    $menus = Menu::findByRestaurant($_GET['restaurant']);
    $json = array();
    foreach ($menus as $m){
        $json[$m->getId()] = $m->getTitle();
    }

    echo json_encode($json);
}
?>