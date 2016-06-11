<?php
include_once('../app/app.php');
Utils::logActivity(basename(__FILE__));


$cities = City::all();
$json = array();

foreach ($cities as $c){
    $json[$c->getId()] = $c->getName();
}

echo json_encode($json);
?>