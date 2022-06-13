<?php

namespace App\Controller\Api;

use App\Db\Pagination;
use App\Model\Entity\User as EntityUser;

class User extends Api
{

    private static function getUserItems(object $request, &$obPagination): array
    {
        $items = [];

        $totalQuantity = EntityUser::getUsers('','','','COUNT(*) as qty')->fetchObject()->qty;

        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($totalQuantity,$currentPage,5);

        $results = EntityUser::getUsers('','id ASC',$obPagination->getLimit());

        while($obUser = $results->fetchObject(EntityUser::class)) {
            $items[] = [
                'id' => $obUser->id,
                'firstName' => $obUser->firstName,
                'lastName' => $obUser->lastName,
                'email' => $obUser->email,
                'createdDate' => $obUser->createdDate
            ];
        }

        return $items;
    }

    public static function getUsers(object $request): array
    {
        return [
            'users' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getUser($request, $id): array
    {
        if(!is_numeric($id)) {
            throw new \Exception("O id ".$id." não é válido.",400);
        }

        $obUser = EntityUser::getUserById($id);

        if(!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário com id ".$id." não foi encontrado.",404);
        }

        return [
            'id' => $obUser->id,
            'firstName' => $obUser->firstName,
            'lastName' => $obUser->lastName,
            'email' => $obUser->email,
            'createdDate' => $obUser->createdDate
        ];
    }

    public static function getCurrentUser($request)
    {
        $obUser = $request->user;

        return [
            'id' => $obUser->id,
            'firstName' => $obUser->firstName,
            'lastName' => $obUser->lastName,
            'email' => $obUser->email,
            'createdDate' => $obUser->createdDate
        ];
    }

    public static function setNewUser(object $request)
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['firstName']) or !isset($postVars['email']) or !isset($postVars['password'])) {
            throw new \Exception("Os campos 'Nome', 'E-mail' e 'Senha' são obrigatórios.",400);
        }

        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if($obUserEmail instanceof EntityUser) {
            throw new \Exception("O e-mail ".$postVars['email']." já está sendo usado.",400);
        }

        $obUser = new EntityUser;
        $obUser->firstName = $postVars['firstName'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $obUser->insertUser();

        return [
            'id' => $obUser->id,
            'firstName' => $obUser->firstName,
            'email' => $obUser->email,
            'createdDate' => $obUser->createdDate
        ];
    }

    public static function setEditUser(object $request, $id)
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['firstName']) or !isset($postVars['email']) or !isset($postVars['password'])) {
            throw new \Exception("Os campos 'Nome', 'E-mail' e 'Senha' são obrigatórios.",400);
        }

        $obUser = EntityUser::getUserById($id);

        if(!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário com id ".$id." não foi encontrado.",404);
        }

        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id) {
            throw new \Exception("O e-mail ".$postVars['email']." já está sendo usado.",400);
        }

        $obUser->firstName = $postVars['firstName'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $obUser->updateUser();

        return [
            'id' => $obUser->id,
            'firstName' => $obUser->firstName,
            'email' => $obUser->email,
            'createdDate' => $obUser->createdDate
        ];
    }

    public static function setDeleteUser(object $request, $id)
    {

        $obUser = EntityUser::getUserById($id);

        if(!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ".$id." não foi encontrado.",404);
        }

        if($obUser->id == $request->user->id) {
            throw new \Exception("Não é possível excluir o cadastro atualmente conectado.", 400);
        }

        $obUser->deleteUser();

        return [
            'success' => true
        ];
    }

}