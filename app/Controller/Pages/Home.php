<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;
use \App\Session\User\Login as SessionUser;
use \App\Controller\User\Home as UserHome;

class Home extends Page
{

    public static function getHome($request): string
    {

        if(SessionUser::isLogged()) {
            return UserHome::getHome($request);
        }

        $obOrganization = new Organization();

        $content =  View::render('pages/home',[
            'name' => $obOrganization->name
        ]);
        return parent::getPage('Home', $content);


    }
}