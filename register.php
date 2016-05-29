<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Registracija</title>
    <link href="public/css/style.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!--    <script type="text/javascript" src="public/js/users.js"></script>-->
<!--    <script type="text/javascript" src="public/js/helpers.js"></script>-->

</head>
<body>
<div id="wrapper">
    <header>
        <h1>Projekt Menze</h1>
        <nav>
            <ul>
                <li><a href="index.php" title="Početna">Home</a></li>
                <li><a href="#" title="Menze">About</a></li>
                <li><a href="users.php" title="Korisnici">Korisnici</a></li>
                <li><a href="#" title="Slike">Work</a></li>
                <li><a href="#" title="O autoru">Contact</a></li>
            </ul>
        </nav>
    </header>
    <div id="content">
        <form class="" id="register" method="post" name="register" action="api/register.php" enctype="multipart/form-data">
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
                    <td><input type="text" id="city" name="city" placeholder="Grad"></td>
                </tr>
                <tr>
                    <td><label for="address">Email:</label></td>
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

</div>
</body>
</html>