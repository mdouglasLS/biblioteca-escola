<?php

namespace App\Controller\Api;

use \App\Model\Entity\User;
use \Firebase\JWT\JWT;
class Auth extends Api
{

    public static function generateToken(object $request): array
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['email']) or !isset($postVars['password'])) {
            throw new \Exception("Os campos 'E-mail' e 'Senha' são obrigatórios.",400);
        }

        $obUser = User::getUserByEmail($postVars['email']);
        if(!$obUser instanceof User or !password_verify($postVars['password'],$obUser->password)) {
            throw new \Exception("E-mail ou senha são inválidos.",400);
        }

        $payload = [
            'email' => $obUser->email
        ];

        return [
            'token' => JWT::encode($payload, getenv('JWT_KEY'),'HS256')
        ];
    }

}