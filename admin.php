<? include('public/template/header.php') ?>
<script type="text/javascript" src="public/js/admin.js"></script>

<?php
    include_once('app/app.php');
    $user = Session::getLoggedInUser();
    if($user != null && UserHelper::isAdmin($user)){
        ?>

        <div id="content">
            <?php
            $buttons = "<a href='admin2.php' ><button class='admin-controls'>Statistika ></button></a>";

            echo $buttons;
            ?>
            <div class="elavated">
                <table id="adminTable">
                    <tbody>
                    <h4>Serversko vrijeme</h4>
                    <tr>
                        <td><input id="timeInput" type="number"></td>
                        <td><input id="getTimeButton" type="button" value="Dohvati vrijeme"></td>
                        <td><input id="setTimeButton" type="button" value="Postavi vrijeme"></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div id="restaurants" class="elavated">
                <h4>Novi restoran</h4>
                <form id="newRestaurant" method="post" name="newRestaurant" action="api/restaurant.php" enctype="multipart/form-data">
                    <table class="fill-horizontal">
                        <tr>
                            <td><label for="name">Naziv: </label></td>
                            <td><input class="" type="text" id="name" name="name" placeholder="naziv" autofocus="autofocus"></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" id="email" name="email" placeholder="E-mail"></td>
                        </tr>
                        <tr>
                            <td><label for="city">Grad:</label></td>
                            <td><select id="city" name="city" placeholder="Grad"></select></td>
                        </tr>
                        <tr>
                            <td><label for="address">Email:</label></td>
                            <td><input type="text" id="address" name="address" placeholder="Adresa"></td>
                        </tr>
                        <tr>
                            <td><label for="image">Profilna slika:</label></td>
                            <td><input type="file" id="image" name="image"></td>
                        </tr>
                        <input type="hidden" name="new" value="new">
                        <tr>
                            <td></td>
                            <td><input id="submit" class="button" type="submit" value="Dodaj restoran">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div>

    <?php
    } else {
        echo "Neautorizirani pristup";
    }
?>


<? include('public/template/footer.php') ?>
