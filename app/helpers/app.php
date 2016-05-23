<?php
define('ADMIN', "3");
define('MOD', "2");
define('USER', "1");

include_once('database.php');
include_once('user.php');
include_once('session.php');
include_once('auth.php');

error_reporting(E_ALL);
function handleError($errno, $errstr,$error_file,$error_line) {
    echo "<b>Error:</b> [$errno] $errstr - $error_file:$error_line";
    echo "<br />";
    echo "Terminating PHP Script";
    die();
}

function handleException($exception) {
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
}

set_exception_handler('handleException');
set_error_handler('handleError');

$dbc = Database::init();

?>