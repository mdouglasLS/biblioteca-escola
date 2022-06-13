<?php

namespace App\Controller\Pages;

use App\Controller\User\MyAccount as UserMyAccount;
use App\Model\Entity\Organization;
use App\Session\User\Login as SessionUser;
use App\Utils\View;
class MyAccount extends Page
{

    public static function getMyAccount($request): string
    {

        if(SessionUser::isLogged()) {
            return UserMyAccount::getMyAccount($request);
        }

        $obOrganization = new Organization();

        $content =  View::render('pages/my-account',[
//            'name' => $obOrganization->name
        ]);
        return parent::getPage('Minha conta', $content);


    }

}