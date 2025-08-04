<?php

namespace App\Models;

use PDO;

class CategoryModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCategories()
    {
        $query = "SELECT category_id, name, image, description, slug
                  FROM categories 
                  ORDER BY category_id ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
