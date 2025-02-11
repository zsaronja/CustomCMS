<?php

namespace Core;

class Session {

    public static function init() {
        session_name(Config::get('app.app-slug', 'mvc-session-cookie'));

        // session_start(['cookie-lifetime' => 60 * 60 * 24 * 30]);
        /**
         * @todo: ne radi cookie-lifetime
         */
    }

    public static function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    public static function initSuperglobals() {
        if (!empty($_REQUEST)) {
            self::set('$_request', $_REQUEST);
        }
    }

    public static function get(string $key, mixed $default = null): mixed {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public static function forget(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function getAndForget(string $key, mixed $default = null): mixed {
        $_value = self::get($key, $default);
        self::forget($key);
        return $_value;
    }

    public static function old(string $key, mixed $default = null): mixed {
        if (isset($_SESSION['$_request'][$key])) {
            $_value = $_SESSION['$_request'][$key];
            unset($_SESSION['$_request'][$key]);
            return $_value;
        }

        return $default;
    }
}