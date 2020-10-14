<?php


namespace models;


use components\ModelAbstract;
use PDO;

class User extends ModelAbstract
{
    public function createUser($user, $password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sql = /** @lang MySQL */
            "INSERT INTO `users` (`name`, `password`) VALUES (:user, :password);";
        $sth = $this->db()->prepare($sql);
        $data = [
            'user' => $user,
            'password' => $password
        ];
        $sth->execute($data);
    }
}