<?php

namespace App\Model;

use PDO;

class OrderListManager extends AbstractManager
{
    public const TABLE = 'orderList';

    public function insert(array $order): void
    {

        $query = "INSERT INTO orderList (summary, total_amount, creation_date)
        VALUES (:summary, :total, NOW());";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':summary', $order['summary'], PDO::PARAM_STR);
        $stmt->bindValue(':total', $order['total'], PDO::PARAM_INT);
        $stmt->execute();
    }
}
