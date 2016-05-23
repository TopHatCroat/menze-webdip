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
        session_name(self::SESSION_NAME);

        if (session_id() == "") {
            session_start();
        }
    }

    static function loginUser($user) {
        self::createSession();
        $_SESSION[self::USER] = $user;
    }

    /**
     * @return User currentrly logged in user
     */
    static function getLoggedInUser(){
        self::createSession();
        if (isset($_SESSION[self::USER])) {
            $user = $_SESSION[self::USER];
        } else {
            $cookie = UserHelper::getRememberCookie();
            $user = User::findByRememberToken($cookie);
            Session::loginUser($user);
        }
        return $user;
    }

    /**
     * Logs User out ie. deletes session
     */
    static function logOutUser() {
        session_name(self::SESSION_NAME);

        if (session_id() != "") {
            session_unset();
            session_destroy();
        }
    }

}
