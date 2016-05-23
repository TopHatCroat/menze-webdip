<?php
/**
 * Function for user authentication
 * @param $username
 * @param $pass
 * @return Returns User instance if authentication is successful, otherwise returns a string error message
 */
function authenticate($username, $pass) {
    global $dbc;
    $sql = "select username, name, surname, password, role, email, mobile from users_z4 where username = '$username';";
    $result = $dbc->queryDB($sql);
    if (!$result) {
        return "Problem kod upita na bazu podataka!";
    }

    $user = new User();

    if ($result->num_rows == 1) {
        list($un, $fn, $ln, $pw, $rl, $em, $mob) = $result->fetch_array();
        if ($pw == $pass) {
            $user->setData($un, $fn, $ln, $rl, $em, $mob);
            return $user;
        }
    }

    return "Krivo korisničko ime ili lozinka";
}

/**
 * @param $role roleType to authorize
 * @return True if logged in user has proper role, otherwise returns string error message
 */
function authorize($role) { //TRIGGERED
    $user = null;

    if (!Session::getLoggedInUser()) {
        return "Neautorizirani pristup";
    } else {
        $user = Session::getLoggedInUser();
        if (is_a($user, 'User')) {
            if($user->getIpAddress() != $_SERVER["REMOTE_ADDR"])
                return "Sigurnosna iznimka! Molimo ponovno se prijavite";

            if(strcmp($user->getRoleType(), $role) == 0)
                return $user;

            return "Neautorizirani pristup";
        }

    }
}
?>
