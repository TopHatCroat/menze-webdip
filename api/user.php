<?php
include_once('../app/app.php');

$users = User::all();
$json = array();

foreach ($users as $u){
    $json[] = $u->toArray();
}

echo json_encode($json);
?>