<? include('public/template/header.php') ?>
<?php
    include_once('app/app.php');
    $user = Session::getLoggedInUser();
    if($user != null && UserHelper::isAdmin($user)){
        echo "<div id='content'></div>";

    } else {
        echo "Neautorizirani pristup";
    }
?>


<? include('public/template/footer.php') ?>
