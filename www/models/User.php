<?php


namespace models;


use components\ModelAbstract;
use PDO;

class User extends ModelAbstract
{
    public function createUser($user, $password)
    {
        if (!$this->checkUserName($user)) {
            echo "User name {$user} already exist."; exit();
        }

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

    private function checkUserName($login)
    {
        $sql = /** @lang MySQL */
            "SELECT `name` FROM `users` WHERE `name` = ?;";
        $sth = $this->db()->prepare($sql);
        $sth->execute([$login]);
        return empty($sth->fetchAll(PDO::FETCH_ASSOC));
    }
}