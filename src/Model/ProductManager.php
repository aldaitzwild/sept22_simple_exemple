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

    public function selectByCategory(int $categoryId): array
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE category_id = :category;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':category', $categoryId);
        $statement->execute();

        $products = $statement->fetchAll();

        return $products;
    }

    public function selectAllWithCategory(): array
    {
        $query = 'SELECT product.id as id, product.name as name, price, isSuper, category.name as categoryName 
        FROM ' . self::TABLE . ' JOIN Category ON product.category_id = category.id';

        return $this->pdo->query($query)->fetchAll();
    }

    public function updateAsSuper(int $id): void
    {
        $statement = $this->pdo->prepare('UPDATE product SET isSuper = 1 WHERE id = :id;');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function insert(array $product): void
    {
        $query = "INSERT INTO " . self::TABLE . " (name, price, category_id)
                VALUES (:name, :price, :category)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $product['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $product['price'], PDO::PARAM_INT);
        $stmt->bindValue(':category', $product['category'], PDO::PARAM_INT);

        $stmt->execute();
    }
}
