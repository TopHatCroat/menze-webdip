<?php

/*
 * The MIT License
 *
 * Copyright 2014 Matija Novak <matija.novak@foi.hr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * Klasa za upravljanje sa sesijama
 *
 * @author Matija Novak <matija.novak@foi.hr>
 */

class Session {
    const USER = "user";
    const SESSION_NAME = "sessionToken";

    static function createSession() {
        if(session_id() == "") session_start();

    }


    /**
     * Logs in user and sets it's session key
     * @param $user
     * @return bool True if successful, false otherwise
     */
    static function loginUser($user) {
        if(!is_a($user, "User")){
            var_dump($user);
            return false;
        }

        Database::logInLog("login", $user->getId());
        $GLOBALS['userId'] = $user->getId();
        self::createSession();
        $_SESSION[self::SESSION_NAME] = session_id();
        $user->setSessionToken($_SESSION[self::SESSION_NAME]);
        $user->save();
        return true;
    }

    /**
     * @return User currentrly logged in user or null if not logged in
     */
    static function getLoggedInUser(){
        self::createSession();
        if (isset($_SESSION[self::SESSION_NAME])) {
            $sessionToken = $_SESSION[self::SESSION_NAME];
            $user = User::findBySessionToken($sessionToken);

            if ($user != null) {
                $GLOBALS['userId'] = $user->getId();
                return $user;
            }
        }
        
        $cookie = UserHelper::getRememberCookie();
        if($cookie != null){
            $user = User::findByRememberToken($cookie);
            if($user != null){
                $GLOBALS['userId'] = $user->getId();
                self::loginUser($user);
                return $user;
            }
        }
        return null;
    }

    /**
     * Logs User out ie. deletes session
     */
    static function logOutUser($user) {
        if(!is_a($user, "User")){
            var_dump($user);
            return false;
        }
        self::createSession();

        $GLOBALS['userId'] = null;

        if (session_id() != "") {
            Database::logInLog("logout", $user->getId());
            session_unset();
            session_destroy();
            unset($_COOKIE["PHPSESSID"]);
            setcookie("PHPSESSID", null, -1);
            unset($_COOKIE[self::SESSION_NAME]);
            setcookie(self::SESSION_NAME, null, -1);
            unset($_COOKIE[session_id()]);
            setcookie(session_id(), null, -1);

        }
        $user->setSessionToken("-1");
        $user->save();
    }

}
