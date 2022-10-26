<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'product';

    public function selectAllTheSuperProducts(): array
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE isSuper = 1;";
        $statement = $this->pdo->query($query);
        $superProducts = $statement->fetchAll();

        return $superProducts;
    }

    public function updateAsSuper(int $id): void
    {
        $statement = $this->pdo->prepare('UPDATE product SET isSuper = 1 WHERE id = :id;');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
