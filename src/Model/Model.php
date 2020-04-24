<?php


namespace App\Model;


abstract class Model
{
    abstract static function getTable(): string;

    abstract function getId(): ?int;

    abstract function setId(?int $id): void;

    public function getFields(): array
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=hw_8_Tolkachev', 'root', 'secret');
        $sql = 'show columns from ' . static::getTable() . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $fields[] = $result['Field'];
        }
        return $fields;
    }

    public function getValue(): array
    {
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $methodName = 'get' . ucfirst($field);
            $values[] = $this->$methodName();
        }
        return $values;
    }

    public static function find(int $id): self
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=hw_8_Tolkachev', 'root', 'secret');
        $sql = 'select * from `' . static::getTable() . '` where `id` = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $instance = new static();
        foreach ($result as $field => $value) {
            $methodName = 'set' . ucfirst($field);
            $instance->$methodName($value);
        }
        var_dump($instance);
        return $instance;
    }

    public function delete(): void
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=hw_8_Tolkachev', 'root', 'secret');
        $sql = 'delete from `' . static::getTable() . '` where `id` = :id';
        $stmt = $pdo->prepare($sql);
        var_dump($this->getId());
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
    }

    public function createOrUpdate(): self
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=hw_8_Tolkachev', 'root', 'secret');
        $sql = 'select * from `' . static::getTable() . '` where `id` = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $fields = $this->getFields();
        $value = $this->getValue();
        $array = array_combine($fields, $value);
        foreach ($fields as $field) {
            if ($field != 'id') {
                $someArray[] = '`' . $field . '` = :' . $field . ' ';
            }
        }
        if ($result === false) {
            $sql = 'insert into `' . static::getTable() . '` set ' . implode(', ', $someArray) . ' ';
            $stmt = $pdo->prepare($sql);
            foreach ($array as $field => $value) {
                if ($field != 'id') {
                    $stmt->bindValue(':' . $field . '', $value);
                }
            }
            $stmt->execute();
            $sql = 'select last_insert_id()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result2 = $stmt->fetch(\PDO::FETCH_ASSOC);
            $id = (int)$result2['last_insert_id()'];
            echo 'Запись создана';
            $this->setId($id);
            //var_dump($this);
            return $this;
        } else {
            $sql = 'update `' . static::getTable() . '` set ' . implode(', ', $someArray) . ' where `id` = :id';
            $stmt = $pdo->prepare($sql);
            foreach ($array as $field => $value) {
                    $stmt->bindValue(':' . $field . '', $value);
                }
            $stmt->execute();
            echo 'Запись обновлена';
           // var_dump($this);
            return $this;
            }
    }
}

