<?php
define('ADMIN', "3");
define('MOD', "2");
define('USER', "1");

include_once('database.php');
include_once('user.php');
include_once('session.php');
include_once('auth.php');

$dbc = new Database();
$dbc->connectDB();
?>