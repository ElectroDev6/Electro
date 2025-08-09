<?php

namespace App\Models;

use PDO;
use PDOException;

class AuthModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createUser(array $data): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password_hash, phone_number, gender, birth_date, role)
                VALUES (:name, :email, :password_hash, :phone_number, :gender, :birth_date, :role)
            ");
            $stmt->execute([
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password_hash' => $data['password_hash'],
                ':phone_number' => $data['phone_number'] ?? null,
                ':gender' => $data['gender'] ?? null,
                ':birth_date' => $data['birth_date'] ?? null,
                ':role' => 'user'
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("AuthModel: Error creating user - " . $e->getMessage());
            return false;
        }
    }
}
