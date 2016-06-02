<?php
include_once('../app/app.php');

$cities = City::all();
$json = array();

foreach ($cities as $c){
    $json[$c->getId()] = $c->getName();
}

echo json_encode($json);
?>