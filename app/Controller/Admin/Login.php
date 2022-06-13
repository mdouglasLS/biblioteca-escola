<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;
class Login extends Page
{

    public static function getLogin(object $request,$errorMessage = null): string
    {
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $content = View::render('admin/login',[
        'status' => $status
        ]);

        return parent::getPage('Login',$content);
    }

    public static function setLogin(object $request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $pass = $postVars['pass'] ?? '';

        $obUser = User::getUserByEmail($email);

        if(!$obUser instanceof User or !password_verify($pass,$obUser->password)) {
            return self::getLogin($request,'E-mail ou senha inválidos!');
        }

        if($obUser->permission_level != 300) {
            return self::getLogin($request,'Acesso restrito para esse usuário!');
        }

        SessionAdminLogin::login($obUser);

        $request->getRouter()->redirect('/admin');
    }

    public static function setLogout(object $request)
    {
        SessionAdminLogin::logout();

        $request->getRouter()->redirect('/admin/login');
    }

}