<?php


namespace Source\Models;

use Source\Core\Model;

class BlackList extends Model
{

    private $segment;

    public function __construct()
    {
        parent::__construct("blacklist");
    }


    public function setSegment(string $segment)
    {
        $this->segment = $segment;
    }

    public function addBlackList()
    {
        if ($this->segment) {
            $result = $this->create(self::$entity, ["phrase" => $this->segment]);

            if (!$result) {
                return $this->fail;
            }
            return true;
        }
    }

    public function load($columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity);

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function showAll(): ?array
    {
        $all = $this->read("SELECT * FROM " . self::$entity);

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function deleteSegment($id)
    {
        if ($id) {
            $this->delete(self::$entity, "id = :id", "id={$id}");
        }

        if ($this->fail()) {
            return null;
        }

        return true;

    }


}