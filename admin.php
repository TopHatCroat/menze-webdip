<? include('public/template/header.php') ?>
<script type="text/javascript" src="public/js/admin.js"></script>

<?php
    include_once('app/app.php');
    $user = Session::getLoggedInUser();
    if($user != null && UserHelper::isAdmin($user)){
        ?>

        <div id="content">
            <table id="adminTable">
                <tbody>
                <tr>
                    <td><input id="timeInput" type="number"></td>
                    <td><input id="getTimeButton" type="button" value="Dohvati vrijeme"></td>
                    <td><input id="setTimeButton" type="button" value="Postavi vrijeme"></td>
                </tr>
                </tbody>
            </table>

        </div>

    <?php
    } else {
        echo "Neautorizirani pristup";
    }
?>


<? include('public/template/footer.php') ?>
