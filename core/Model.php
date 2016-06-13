<?php

namespace core;

class Model extends \vendor\PDOWrapper
{
    public function __construct()
    {
        parent::__construct(Application::$config['database']);
    }

    public function count($where = '2 > 1')
    {
        $sql = "SELECT count(*) as count FROM `{$this->table}` WHERE {$where}";
        $row = $this->getOne($sql);
        return $row['count'];
    }

    public function findAll($where = '2' > '1', $order = 'id ASC', $offset = 0, $limit = false)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where} ORDER BY {$order} ";
        if ($limit !== false) {
            $sql .= "LIMIT {$offset},{$limit}";
           // echo $sql; die;

        }
        return $this->getAll($sql);
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE id={$id}";
        return $this->getOne($sql);
    }

    public function findOneBy($where = '2 > 1')
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where} LIMIT 1";
        return $this->getOne($sql);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM `{$this->table}` WHERE id={$id}";
        return $this->exec($sql);
    }

    public function add($data)
    {
        $columns = '';
        $values = '';
        foreach($data as $column => $value) {
            $columns = $columns . $column . ',';
            $values = $values . "'" . $value . "'" .',';
        }
        $columns = rtrim($columns, ',');
        $values = rtrim($values, ',');
        $sql = "INSERT INTO `{$this->table}` ($columns) VALUES ($values)";
        return $this->exec($sql);
    }

    public function updateById($id, $data)
    {
        $sets = '';
        foreach($data as $column => $value) {
            $sets = $sets . "{$column}='{$value}',";
        }
        $sets = rtrim($sets, ',');
        $sql = "UPDATE `{$this->table}` set {$sets} WHERE id={$id}";
        return $this->exec($sql);
    }

    public static function create($modelClassName = false)
    {
        static $models = array();
        if (!$modelClassName) {
            $modelClassName = get_called_class();
        }
        if (isset($models[$modelClassName])) {
            return $models[$modelClassName];
        } else {
           return new $modelClassName;
        }
    }

    public function limitlessLevelCategory($categorys, $level = 0, $parentId = 0)
    {
        static $limitlessLevelCategory = array();

        foreach ($categorys as $category) {
            if ($category['parent_id'] == $parentId) {
                $category['level'] = $level;
                $limitlessLevelCategory[] = $category;
                $this->limitlessLevelCategory($categorys, $level + 1, $category['id']);
            }
        }
        return $limitlessLevelCategory;
    }
}
