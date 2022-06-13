<?php

namespace App\Controller\Admin;

use \App\Utils\View;
class Alert
{

    public static function getSuccess(string $message): string
    {
        return View::render('admin/alert/status',[
            'type' => 'success',
            'message' => $message
            ]);
    }

    public static function getError(string $message): string
    {
        return View::render('admin/alert/status',[
            'type' => 'danger',
            'message' => $message
            ]);
    }

}