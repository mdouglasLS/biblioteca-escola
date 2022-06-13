<?php

namespace App\Controller\Pages;

use \App\Utils\View;
class Signup extends Page
{

    public static function getFormSignup(object $request)
    {

        $content =  View::render('pages/signup',[

        ]);
        return parent::getPage('Cadastre-se', $content);
    }

}