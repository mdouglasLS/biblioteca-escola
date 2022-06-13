<?php

namespace App\Controller\User;

use App\Controller\User\Alert;
use App\Model\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;
use App\Session\User\Login as SessionUserLogin;
use App\Utils\View;

class Login extends Page
{

    public static function getLogin(object $request,$errorMessage = null): string
    {
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $content = View::render('user/login',[
            'status' => $status
        ]);

        return parent::getPage('Entrar',$content);
    }

    public static function setLogin(object $request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        $obUser = User::getUserByEmail($email);
        if(!$obUser instanceof User or !password_verify($password,$obUser->password)) {
            return self::getLogin($request,'E-mail ou senha inválidos!');
        }

        SessionUserLogin::login($obUser);

        $request->getRouter()->redirect('/user');
    }

    public static function setLogout(object $request)
    {

        SessionUserLogin::logout();

        $request->getRouter()->redirect('/');
    }

}