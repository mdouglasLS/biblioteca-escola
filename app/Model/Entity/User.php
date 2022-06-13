<?php

namespace App\Model\Entity;

use \App\Db\Database;
class User
{

    public int $id;

    public int $permissionLevel;

    public int $status;

    public string $firstName;

    public string $lastName;

    public string $birthdate;

    public string $cpf;

    public int $gender;

    public string $email;

    public string $password;

    public string $createdDate;

    public string $updatedDate;

    public function insertUser(): bool
    {
        $this->createdDate = date('Y-m-d H:i:s');
        $this->id = (new Database('users'))->insert([
            'permission_level' => $this->permissionLevel,
            'status' => $this->status,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'birthdate' => $this->birthdate,
            'cpf' => $this->cpf,
            'gender' => $this->gender,
            'email' => $this->email,
            'password' => $this->password
        ]);
        return true;
    }

    public function updateUser()
    {
        return (new Database('users'))->update('id = '.$this->id,[
            'permission_level' => $this->permissionLevel,
            'status' => $this->status,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'birthdate' => $this->birthdate,
            'cpf' => $this->cpf,
            'gender' => $this->gender,
            'email' => $this->email
        ]);
    }

    public function updatePasswordUser()
    {
        return (new Database('users'))->update('id = '.$this->id,[
            'password' => $this->password
        ]);
    }

    public static function getUserById(int $id)
    {
        return self::getUsers('id = '.$id)->fetchObject(self::class);
    }

    public static function getUserByEmail(string $email)
    {
        return self::getUsers('email = "'.$email.'"')->fetchObject(self::class);
    }

    public static function getUserByCpf(string $cpf)
    {
        return self::getUsers('cpf = "'.$cpf.'"')->fetchObject(self::class);
    }

    public static function getUserByName(string $name)
    {
        return self::getUsers('first_name = "'.$name.'"')->fetchObject(self::class);
    }

    public static function getUsers($where = '', $order = '', $limit = '', $fields = '*')
    {
        return (new Database('users'))->select($where,$order,$limit,$fields);
    }

}