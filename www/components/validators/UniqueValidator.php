<?php


namespace components\validators;


use components\App;

class UniqueValidator extends ValidatorAbstract
{
    private string $table;
    private string $field;

    public function __construct(string $table, string $field, string $error)
    {
        $this->table = $table;
        $this->field = $field;
        $this->error = $error;
    }

    public function validate($data)
    {
        $this->error = sprintf($this->error, $data);

        $db = App::get()->dbConnection();
        $sql = "SELECT 1 FROM `{$this->table}` WHERE `{$this->field}` = :name";
        $sth = $db->prepare($sql);
        $sth->execute([':name' => $data]);

        return !(bool)$sth->fetchColumn();
    }
}