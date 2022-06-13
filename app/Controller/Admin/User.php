<?php

namespace App\Controller\Admin;

use App\Db\Pagination;
use App\Model\Entity\User as EntityUser;
use App\Utils\View;
class User extends Page
{
    private static function getUserItems(object $request, &$obPagination)
    {
        $items = '';

        $totalQuantity = EntityUser::getUsers('', '', '', 'COUNT(*) as qty')->fetchObject()->qty;

        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($totalQuantity, $currentPage, 5);

        $results = EntityUser::getUsers('', 'id DESC', $obPagination->getLimit());

        while ($obUser = $results->fetchObject(EntityUser::class)) {
            $items .= View::render('admin/modules/users/item', [
                'id' => $obUser->id,
                'firstName' => $obUser->firstName,
                'email' => $obUser->email
            ]);
        }

        return $items;
    }

    public static function getUsers($request)
    {

        $content = View::render('admin/modules/users/index', [
            'items' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Usuários > Wdev', $content, 'users');
    }

    public static function getNewUser(object $request)
    {
        $content = View::render('admin/modules/users/form', [
            'title' => 'Cadastrar usuário',
            'firstName' => '',
            'email' => '',
            'status' => self::getStatus($request)
        ]);
        return parent::getPanel('Cadastrar usuário', $content, 'users');
    }

    public static function setNewUser(object $request)
    {
        $postVars = $request->getPostVars();
        $firstName = $postVars['firstName'] ?? '';
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        $obUser = EntityUser::getUserByEmail($email);
        if($obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/usuarios/new?status=duplicated');
        }

        $obUser = new EntityUser;
        $obUser->firstName = $firstName;
        $obUser->email = $email;
        $obUser->password = password_hash($password, PASSWORD_DEFAULT);
        $obUser->insertUser();

        $request->getRouter()->redirect('/admin/usuarios/'.$obUser->id.'/edit?status=created');

    }

    private static function getStatus(object $request)
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Usuario cadastrado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso!');
                break;
            case 'duplicated':
                return Alert::getError('O e-mail digitado já está sendo utilizado por outro usuário!');
                break;
        }
    }

    public static function getEditUser(object $request, int $id)
    {
        $obUser = EntityUser::getUserById($id);

        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/usuarios');
        }

        $content = View::render('admin/modules/users/form', [
            'title' => 'Editar Usuario',
            'firstName' => $obUser->firstName,
            'email' => $obUser->email,
            'status' => self::getStatus($request)
        ]);
        return parent::getPanel('Editar usuário', $content, 'users');
    }

    public static function setEditUser(object $request, int $id)
    {
        $obUser = EntityUser::getUserById($id);

        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/usuarios');
        }

        $postVars = $request->getPostVars();
        $firstName =  $postVars['firstName'] ?? '';
        $email =  $postVars['email'] ?? '';
        $password =  $postVars['password'] ?? '';

        $obUserEmail = EntityUser::getUserByEmail($email);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $id) {
            $request->getRouter()->redirect('/admin/usuarios/'.$id.'/edit?status=duplicated');
        }

        $obUser->firstName = $firstName;
        $obUser->email = $email;
        $obUser->password = password_hash($password, PASSWORD_DEFAULT);
        $obUser->updateUser();

        $request->getRouter()->redirect('/admin/usuarios/'.$id.'/edit?status=updated');
    }

}