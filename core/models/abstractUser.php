<?php

namespace Core\Models;

abstract class AbstractUser {

    const LOGGED_IN_STATUS = 'is_logged_in';
    const LOGGED_IN_USER_ID = 'logged_in_user_id';

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function login(?string $redirect): bool
    {
        Session::set(self::LOGGED_IN_STATUS, true);
        Session::set(self::LOGGED_IN_USER_ID, $this->id);

        Redirector::redirect($redirect);

        return true;
    }

    public static function isLoggedIn(): bool {

        /**
         * @todo: logged in status vjerojatno ne radi
         */
        if (
            Session::get(self::LOGGED_IN_STATUS, false) === true 
            && Session::get(self::LOGGED_IN_USER_ID, null) !== null
        ) {
            return true;
        }

        return false;
    }
}