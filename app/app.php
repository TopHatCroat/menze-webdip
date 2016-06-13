<?php
define('ADMIN', "3");
define('MOD', "2");
define('USER', "1");

//include_once('helpers/errorReporting.php');
include_once('helpers/database.php');
include_once('helpers/utils.php');
include_once('models/user.php');
include_once('models/city.php');
include_once('models/Picture.php');
include_once('models/Restaurant.php');
include_once('models/Menu.php');
include_once('models/Reservation.php');
include_once('models/DailyMenu.php');
include_once('models/role.php');
include_once('helpers/userHelper.php');
include_once('helpers/session.php');
include_once('helpers/auth.php');
include_once('helpers/Settings.php');

$dbc = Database::init();

?>