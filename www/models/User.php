<?php


namespace models;


use components\ActiveRecord;
use components\App;
use components\Builder;

class User extends ActiveRecord
{
//    public function createUser($user, $password)
//    {
//        $password = password_hash($password, PASSWORD_BCRYPT);
//        $sql = /** @lang MySQL */
//            "INSERT INTO `users` (`name`, `password`) VALUES (:user, :password);";
//        $sth = $this->db()->prepare($sql);
//        $data = [
//            'user' => $user,
//            'password' => $password
//        ];
//        $sth->execute($data);
//    }
//
//    public function findUser($user)
//    {
//        $sql = /** @lang MySQL */
//            "SELECT * FROM users WHERE `name` = :name;";
//        $sth = $this->db()->prepare($sql);
//        $data = [
//            'name' => $user
//        ];
//        $sth->execute($data);
//        return $sth->fetch(PDO::FETCH_ASSOC);
//    }
    protected function getTable(): string
    {
        return 'users';
    }
}