<?php

namespace App\Models;

use PDO;

class ProfileModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserProfile(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT user_id, name, phone_number, email, gender, birth_date, avatar_url
            FROM users
            WHERE user_id = :user_id AND is_active = TRUE
            LIMIT 1
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getDefaultAddress(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT address_line1, ward_commune, district, province_city
            FROM user_address
            WHERE user_id = :user_id AND is_default = TRUE
            LIMIT 1
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
