<?php

namespace App\Session\Admin;

class Login
{

    private static function init()
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($obUser): bool
    {
        self::init();

        $_SESSION['user'] = [
            'id' => $obUser->id,
            'permissionLevel' => $obUser->permission_level,
            'status' => $obUser->status,
            'firstName' => $obUser->first_name,
            'lastName' => $obUser->last_name,
            'birthdate' => $obUser->birthdate,
            'cpf' => $obUser->cpf,
            'gender' => $obUser->gender,
            'email' => $obUser->email,
            'createdAt' => $obUser->created_at,
            'updatedAt' => $obUser->updated_at
        ];

        return true;
    }

    public static function isLogged()
    {
        self::init();

        if($_SESSION['user']['permissionLevel'] != 300) {
            return false;
        }

        return isset($_SESSION['user']['id']);
    }

    public static function logout(): bool
    {
        self::init();

        unset($_SESSION['user']);

        return true;
    }

}