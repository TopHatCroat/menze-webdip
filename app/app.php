<?php
define('ADMIN', "3");
define('MOD', "2");
define('USER', "1");

include_once('helpers/errorReporting.php');
include_once('helpers/database.php');
include_once('models/user.php');
include_once('helpers/userHelper.php');
include_once('helpers/session.php');
include_once('helpers/auth.php');

$dbc = Database::init();

?>