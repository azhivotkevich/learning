<?php


namespace components;


use Exception;
use PDO;

abstract class ActiveRecord
{
    private array $columns = [];

    public function __construct()
    {
        $this->setColumns();
    }

    /**
     * @return string
     */
    abstract protected function getTable(): string;

    private function setColumns(): void
    {
        $columns = Builder::select(['COLUMN_NAME'])
            ->from('`INFORMATION_SCHEMA`.`COLUMNS`')
            ->where([['TABLE_NAME', '=', $this->getTable()]])
            ->column();

        $this->columns =  array_fill_keys($columns, null);
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->columns)) {
            throw new Exception("Property {$name} doesn't exist");
        }
        $this->columns[$name] = $value;
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->columns)) {
            throw new Exception("Property {$name} doesn't exist");
        }
        return $this->columns[$name];
    }

    public static function find(array $where = []): array
    {
        $model = new static();
        $data = Builder::select()->from($model->getTable())->where($where)->all();

        $userModels = [];

        foreach ($data as $row) {
            $userModel = new static();
            $userModel->load($row);
            $userModels[] = $userModel;
        }

        return $userModels;
    }

    public static function findOne(array $where = []): self
    {
        $model = new static();
        $data = Builder::select()->from($model->getTable())->where($where)->one();
        $model->load($data);

        return $model;
    }

    public function save()
    {
        $where = [];
        foreach ($this->getPrimaryKeys() as $key) {
            $where[] = [$key, '=', $this->{$key}];
        }

        Builder::update($this->getTable())->set($this->columns)->where($where)->execute();
    }

    private function getPrimaryKeys(): array
    {
        $db = App::get()->dbConnection();
        $sql = "SHOW KEYS FROM {$this->getTable()} WHERE Key_name = 'PRIMARY'";
        $sth = $db->prepare($sql);
        $sth->execute();
        $columns = $sth->fetchAll(PDO::FETCH_ASSOC);

        $keys = [];

        foreach ($columns as $value) {
            $keys[] = $value['Column_name'];
        }

        if (!$keys) {
            throw new Exception('There is no primary keys!');
        }

        return $keys;
    }

    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}