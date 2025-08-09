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
    SELECT user_id, name, phone_number, email, gender, dob_day, dob_month, dob_year, avatar_url
    FROM users
    WHERE user_id = :user_id AND is_active = 1
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

    public function updateUserProfile(int $userId, array $data): bool
    {
        try {
            $sql = "UPDATE users SET 
                name = :name, 
                phone_number = :phone_number, 
                email = :email, 
                gender = :gender, 
                dob_day = :dob_day, 
                dob_month = :dob_month, 
                dob_year = :dob_year 
                WHERE user_id = :user_id";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':name' => $data['name'],
                ':phone_number' => $data['phone_number'],
                ':email' => $data['email'],
                ':gender' => $data['gender'],
                ':dob_day' => $data['dob_day'],
                ':dob_month' => $data['dob_month'],
                ':dob_year' => $data['dob_year'],
                ':user_id' => $userId,
            ]);
        } catch (\PDOException $e) {
            error_log("ProfileModel updateUserProfile error: " . $e->getMessage());
            return false;
        }
    }

   public function updateUserAddress(int $userId, array $data): bool
{
    try {
        // Kiểm tra xem đã có địa chỉ cho user chưa
        $sqlCheck = "SELECT COUNT(*) FROM user_address WHERE user_id = :user_id";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([':user_id' => $userId]);
        $exists = $stmtCheck->fetchColumn() > 0;

        if ($exists) {
            $sql = "UPDATE user_address SET province_city = :province_city, district = :district, ward_commune = :ward_commune, address_line1 = :address_line1 WHERE user_id = :user_id";
        } else {
            $sql = "INSERT INTO user_address (user_id, province_city, district, ward_commune, address_line1) VALUES (:user_id, :province_city, :district, :ward_commune, :address_line1)";
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':province_city' => $data['province_city'],
            ':district' => $data['district'],
            ':ward_commune' => $data['ward_commune'],
            ':address_line1' => $data['address_line1'],
        ]);
    } catch (\PDOException $e) {
        error_log("ProfileModel updateUserAddress error: " . $e->getMessage());
        return false;
    }
}
}