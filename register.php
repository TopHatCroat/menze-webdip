<? include('public/template/header.php') ?>
    <script type="text/javascript" src="public/js/register.js"></script>

<div id="content">
    <form id="register" method="post" name="register" action="api/register.php" enctype="multipart/form-data">
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
                <td><label for="pass-confirm">Provjera lozinke:</label></td>
                <td><input class="" type="password" id="pass-confirm" name="pass-confirm" placeholder="lozinka"></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" placeholder="E-mail"></td>
            </tr>
            <tr>
                <td><label for="name">Ime:</label></td>
                <td><input type="text" id="name" name="name" placeholder="Ime"></td>
            </tr>
            <tr>
                <td><label for="surname">Prezime:</label></td>
                <td><input type="text" id="surname" name="surname" placeholder="Prezime"></td>
            </tr>
            <tr>
                <td><label for="city">Grad:</label></td>
                <td><select id="city" name="city" placeholder="Grad"></select></td>
            </tr>
            <tr>
                <td><label for="address">Adresa:</label></td>
                <td><input type="text" id="address" name="address" placeholder="Adresa"></td>
            </tr>
            <tr>
                <td><label for="image">Profilna slika:</label></td>
                <td><input type="file" id="image" name="image"></td>
            </tr>
            <tr>
                <td></td>
                <td><input id="submit" class="button" type="submit" value="Registriraj se">
                </td>
            </tr>
        </table>
    </form>
</div>

<? include('public/template/footer.php') ?>