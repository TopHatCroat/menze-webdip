<? include('public/template/header.php') ?>

<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="public/js/admin.js"></script>


<?php
include_once('app/app.php');
$user = Session::getLoggedInUser();
if($user != null && UserHelper::isAdmin($user)){
    ?>

    <div id="content">
        <?php
        $buttons = "<a href='admin.php' ><button class='admin-controls'>< Glavno</button></a>";

        echo $buttons;

        $tableHtml = '';
        $tableHtml .= "<table id='generalLog'>  <caption class='card-title'>KORISNIČKI ZAHTJEVI</caption>";

        $data = Database::query("SELECT * FROM general_log");
        $tableHtml .= "<thead><tr><th>Akcija</th><th>IP</th><th>Vrijeme</th><th>Korisnik</th></tr></thead><tbody>";
        while ($row = $data->fetch_assoc()) {
            $tableHtml .= "<tr><td>" . $row['action'] . "</td><td>" . $row['ip'] . "</td><td>" . $row['created_at'] . "</td><td>" . $row['users_id'] . "</td></tr>";
        }

        $tableHtml .= "</tbody></table>";

        $tableHtml .= "<table id=logInLog> <caption class='card-title'>PRIJAVE I ODJAVE</caption>";

        $data = Database::query("SELECT * FROM log_in_log");
        $tableHtml .= "<thead><tr><th>Akcija</th><th>Vrijeme</th><th>Korisnik</th></tr></thead><tbody>";
        while ($row = $data->fetch_assoc()) {
            $tableHtml .= "<tr><td>" . $row['action'] . "</td><td>" . $row['created_at'] . "</td><td>" . $row['users_id'] . "</td></tr>";
        }

        $tableHtml .= "</tbody></table>";

        $tableHtml .= "<table id=dbLog> <caption class='card-title'>UPITI NA BAZU</caption>";

        $data = Database::query("SELECT * FROM db_log");
        $tableHtml .= "<thead><tr><th>Upit</th><th>Vrijeme</th><th>Korisnik</th></tr></thead><tbody>";
        while ($row = $data->fetch_assoc()) {
            $tableHtml .= "<tr><td>" . $row['query'] . "</td><td>" . $row['created_at'] . "</td><td>" . $row['users_id'] . "</td></tr>";
        }

        $tableHtml .= "</tbody></table>";

        echo $tableHtml;
        ?>
    </div>

    <?php
} else {
    echo "Neautorizirani pristup";
}
?>


<? include('public/template/footer.php') ?>
