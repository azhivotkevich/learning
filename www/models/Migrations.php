<?php


namespace models;


use cli\helpers\Colors;
use components\App;
use components\ModelAbstract, PDO;
use helpers\Dir;

class Migrations extends ModelAbstract
{
    public function createMigrationsTable(): void
    {
        $result = $this->db()->exec(/** @lang MySQL */ '
                    CREATE TABLE IF NOT EXISTS `migrate` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT primary key,
                    `file` varchar(255) NOT NULL,
                    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP)');

        if ($result === false) {
            throw new \Exception("Can't create migrate table! \r\n");
        }

        Colors::print("Migrations are ready \r\n", 'green');
    }

    public function getNewMigrations()
    {
        $allMigrations = $this->getAllMigrations();
        $executedMigrations = $this->getExecutedMigrations();

        return array_diff($allMigrations, $executedMigrations);
    }

    private function getAllMigrations(): array
    {
        return Dir::scan(App::get()->config()->get('migrationsDir'));
    }

    private function getExecutedMigrations()
    {
        $sql = "SELECT `file` FROM `migrate`";
        $sth = $this->db()->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }

    public function executeMigration($file)
    {
        $file = App::get()->config()->get('migrationsDir') . $file;
        $sql = file_get_contents($file);

        return false !== $this->db()->exec($sql);
    }

    public function saveMigrationStatus($file): void
    {
        $sql = "INSERT INTO `migrate` (`file`) VALUES (:file)";
        $sth = $this->db()->prepare($sql);
        $sth->execute([':file' => $file]);
    }
}