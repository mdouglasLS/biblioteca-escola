<?php

namespace App\Controller\User;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{

    public static function getAbout($request)
    {

//        $obOrganization = new Organization();
//
//        $content =  View::render('pages/about',[
//            'name' => $obOrganization->name,
//            'description' => $obOrganization->about,
//            'site' => $obOrganization->site
//        ]);
        return parent::getPage('Sobre', 'About user');

    }

}