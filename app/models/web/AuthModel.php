<?php

namespace App\Models\Web;

use PDO;

class AuthModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users"); // hoặc `user` nếu table tên khác
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
