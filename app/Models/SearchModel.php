<?php

namespace App\Models;

class SearchModel
{
    public function searchByName(string $keyword): array
    {
        $pdo = \Container::get('pdo');

        $stmt = $pdo->prepare("
            SELECT product_id, name
            FROM products
            WHERE name LIKE ?
            LIMIT 5
        ");
        $stmt->execute(['%' . $keyword . '%']);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
