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

    public function getUserByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name = :name LIMIT 1");
        $stmt->execute([':name' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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
                INSERT INTO users (name, email, password_hash, phone_number, role)
                VALUES (:name, :email, :password_hash, :phone_number, :role)
            ");
            $stmt->execute([
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password_hash' => $data['password_hash'],
                ':phone_number' => $data['phone_number'] ?? null,
                ':role' => $data['role'] ?? 'user'
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("AuthModel: Error creating user - " . $e->getMessage());
            return false;
        }
    }
    public function savePasswordResetToken(string $email, string $token, string $expiresAt): bool
{
    $stmt = $this->pdo->prepare("REPLACE INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at)");
    return $stmt->execute([
        ':email' => $email,
        ':token' => $token,
        ':expires_at' => $expiresAt
    ]);
}

public function getPasswordResetByToken(string $token): ?array
{
    $stmt = $this->pdo->prepare("SELECT * FROM password_resets WHERE token = :token LIMIT 1");
    $stmt->execute([':token' => $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

public function deletePasswordResetToken(string $email): bool
{
    $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE email = :email");
    return $stmt->execute([':email' => $email]);
}

public function updateUserPassword(string $email, string $passwordHash): bool
{
    $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE email = :email");
    return $stmt->execute([
        ':password_hash' => $passwordHash,
        ':email' => $email
    ]);
}

}