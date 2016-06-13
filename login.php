<? include('public/template/header.php') ?>
<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
?>

<script type="text/javascript" src="public/js/login.js"></script>
<div id="content">

    <form class="" id="login" method="post" name="login" action="api/login.php" enctype="multipart/form-data">
        <table class="fill-horizontal">
            <tr>
                <td><label for="username">Korisničko ime: </label></td>
                <td><input class="" type="text" id="username" name="username" placeholder="korisničko ime" autofocus="autofocus"></td>
            </tr>
            <tr>
                <td><label for="pass">Lozinka:</label></td>
                <td><input class="" type="password" id="pass" name="pass" placeholder="lozinka"></td>
            </tr>
            <tr>
                <td><label for="remember">Upamti me?</label></td>
                <td><input id="remember" type="checkbox" name="remember"></td>
            </tr>
            <tr>
                <td></td>
                <td><input id="submit" class="button" type="submit" value="Prijavi se">
                </td>
            </tr>
        </table>
    </form>
</div>

<? include('public/template/footer.php') ?>
