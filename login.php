<? include('public/template/header.php') ?>
<script type="text/javascript" src="public/js/login.js"></script>

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
<? include('public/template/footer.php') ?>
