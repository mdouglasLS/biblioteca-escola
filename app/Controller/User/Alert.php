<?php

namespace App\Controller\User;

use App\Utils\View;

class Alert
{

    public static function getSuccess(string $message): string
    {
        return View::render('user/alert/status',[
            'type' => 'success',
            'message' => $message
        ]);
    }

    public static function getError(string $message): string
    {
        return View::render('user/alert/status',[
            'type' => 'danger',
            'message' => $message
        ]);
    }

}