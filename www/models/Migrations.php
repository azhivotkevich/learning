<?php


namespace models;


use cli\helpers\Colors;
use components\ModelAbstract, PDO;

class Migrations extends ModelAbstract
{

    private function createTable(): void
    {
        $sth = $this->db()->prepare(/** @lang MySQL */ '
                    CREATE TABLE IF NOT EXISTS `migrate` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT primary key,
                    `file` varchar(255) NOT NULL,
                    `date` date NOT NULL)');

        if (!$sth->execute()) {
            throw new \Exception("Can't create `migrate` table");
        }

        Colors::print("Table `migrate` was successfully created! \r\n", 'green', '42');
    }

    public function verifyTable(): void
    {
        $sth = $this->db()->prepare(/** @lang MySQL */ 'SELECT 1 FROM `migrate`');
        if (!$sth->execute()) {
            $this->createTable();
        }
    }

    public function getExecutedFiles(array $fileNames): array
    {
        $placeholders = substr(str_repeat('?,', count($fileNames)), 0, -1);
        $sql = /** @lang MySQL */
            "SELECT `file` FROM `migrate` WHERE `file` IN ({$placeholders})";
        $sth = $this->db()->prepare($sql);
        $sth->execute($fileNames);

        $fileNames = [];
        if ($sth->rowCount() > 0) {
            foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $names) {
                $fileNames[] = $names['file'];
            }
        }
        return $fileNames;
    }

    public function execute(string $sth): bool
    {
        $sth = $this->db()->prepare($sth);
        if (!$sth->execute()) {
            return false;
        }
        return true;
    }

    public function setExecuted(string $file): void
    {
        $sql = /** @lang MySQL */
            "INSERT INTO `migrate` (`file`, `date`) VALUES (:file,:date)";
        $sth = $this->db()->prepare($sql);
        $sth->execute(['file' => $file, 'date' => date('Y-m-d')]);
    }
}