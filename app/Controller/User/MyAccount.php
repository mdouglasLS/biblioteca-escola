<?php

namespace App\Controller\User;

use App\Utils\View;
class MyAccount extends Page
{

    public static function getMyAccount($request): string
    {


//        $content =  View::render('pages/my-account',[
////            'name' => $obOrganization->name
//        ]);
        return parent::getPage('Minha conta', 'Dados do usuario');


    }

}