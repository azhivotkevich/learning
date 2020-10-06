<?php


namespace models;


use components\ModelAbstract;

class User extends ModelAbstract
{
    public function createUser($user, $password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO `users` (`name`, `password`) VALUES (:user, :password);";
        $sth = $this->db()->prepare($sql);
        $sth->execute([
            'user' => $user,
            'password' => $password
        ]);
    }
}