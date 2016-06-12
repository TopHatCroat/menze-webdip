<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));
$json = array();

if(isset($_POST['newDailyMenu'])) {
    if (isset($_POST['type']) && !empty($_POST['type'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['type'])) {
            $json['errors'][] = "Tip sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Tip mora biti unesen";

    if (isset($_POST['amount']) && !empty($_POST['amount'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['amount'])) {
            $json['errors'][] = "Količina sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Količina mora biti unesen";

    if (isset($_POST['sold']) && !empty($_POST['sold'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['sold'])) {
            $json['errors'][] = "Prodano sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Prodano mora biti unesen";
    
    if (isset($_POST['menu']) && !empty($_POST['menu'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['menu'])) {
            $json['errors'][] = "Menu sadrži nedozvoljene znakove";
        }
        if(Menu::findById($_POST['menu']) == null) $json['errors'][] = "Menu ne postoji";
        
    } else $json['errors'][] = "Menu mora biti unesen";

    if (isset($_POST['restaurant']) && !empty($_POST['restaurant'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['restaurant'])) {
            $json['errors'][] = "Restoran sadrži nedozvoljene znakove";
        }
        if(Restaurant::findById($_POST['restaurant']) == null) $json['errors'][] = "Restoran ne postoji";
    } else $json['errors'][] = "Restoran mora biti unesen";

    

    if (!isset($json['errors'])) {
        $editDailyMenu = new DailyMenu();

        $editDailyMenu->setType($_POST["type"]);
        $editDailyMenu->setAmount($_POST["amount"]);
        $editDailyMenu->setSold($_POST["sold"]);
        $editDailyMenu->setMenu($_POST["menu"]);
        $editDailyMenu->setRestaurant($_POST["restaurant"]);

        $editDailyMenu->save();
        $success["success"] = "Uspješno dodan novi menu";
    }
    echo json_encode($success);
}

if(isset($_POST['editDailyMenu'])) {
    if(DailyMenu::findById($_POST['editDailyMenu']) == null) $json['errors'][] = "Dnevni meni ne postoji";

    if (isset($_POST['type']) && !empty($_POST['type'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['type'])) {
            $json['errors'][] = "Tip sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Tip mora biti unesen";

    if (isset($_POST['amount']) && !empty($_POST['amount'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['amount'])) {
            $json['errors'][] = "Količina sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Količina mora biti unesen";

    if (isset($_POST['sold']) && !empty($_POST['sold'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['sold'])) {
            $json['errors'][] = "Prodano sadrži nedozvoljene znakove";
        }
    } else $json['errors'][] = "Prodano mora biti unesen";

    if (isset($_POST['menu']) && !empty($_POST['menu'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['menu'])) {
            $json['errors'][] = "Menu sadrži nedozvoljene znakove";
        }
        if(Menu::findById($_POST['menu']) == null) $json['errors'][] = "Menu ne postoji";

    } else $json['errors'][] = "Menu mora biti unesen";

    if (isset($_POST['restaurant']) && !empty($_POST['restaurant'])) {
        if (preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\') | (\-\-)|(\%3B)|(;))/i', $_POST['restaurant'])) {
            $json['errors'][] = "Restoran sadrži nedozvoljene znakove";
        }
        if(Restaurant::findById($_POST['restaurant']) == null) $json['errors'][] = "Restoran ne postoji";
    } else $json['errors'][] = "Restoran mora biti unesen";

    if (!isset($json['errors'])) {
        $editDailyMenu = DailyMenu::findById($_POST['editDailyMenu']);

        if((intval($editDailyMenu->getAmount()) - intval($editDailyMenu->getSold())) < 10 ) $json['errors'][] = "Količina je premala";

        $editDailyMenu->setType($_POST["type"]);
        $editDailyMenu->setAmount($_POST["amount"]);
        $editDailyMenu->setSold($_POST["sold"]);
        $editDailyMenu->setMenu($_POST["menu"]);
        $editDailyMenu->setRestaurant($_POST["restaurant"]);

        if(!isset($json['errors'])){
            $editDailyMenu->save();
            $success["success"] = "Uspješno dodan novi menu";
        }
    }
    echo json_encode($success);
}
?>