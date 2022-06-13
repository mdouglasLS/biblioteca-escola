<?php

namespace App\Controller\Pages;

use App\Controller\User\About as UserAbout;
use App\Session\User\Login as SessionUser;
use \App\Utils\View;
use \App\Model\Entity\Organization;
class About extends Page
{
    public static function getAbout($request)
    {
        if(SessionUser::isLogged()) {
            return UserAbout::getAbout($request);
        }

        $obOrganization = new Organization();

        $content =  View::render('pages/about',[
            'name' => $obOrganization->name,
            'description' => $obOrganization->about,
            'site' => $obOrganization->site
        ]);
        return parent::getPage('Sobre', $content);
    }
}