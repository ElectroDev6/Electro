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
            SELECT address, ward_commune, district, province_city
            FROM user_address
            WHERE user_id = :user_id
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

    public function updateUserAvatar(int $userId, array $file): bool
    {
        try {
            // Kiểm tra file upload
            if (!isset($file['avatar']) || $file['avatar']['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            $fileTmp = $file['avatar']['tmp_name'];
            $fileName = basename($file['avatar']['name']);

            // Thư mục lưu ảnh
            $uploadDir = 'img/avatars/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $targetPath = $uploadDir . $fileName;

            if (!move_uploaded_file($fileTmp, $targetPath)) {
                return false;
            }

            // Cập nhật database
            $sql = "UPDATE users SET avatar_url = :avatar_url WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':avatar_url' => 'img/avatars/' . $fileName,
                ':user_id' => $userId
            ]);
        } catch (\PDOException $e) {
            error_log("ProfileModel updateUserAvatar error: " . $e->getMessage());
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
                $sql = "UPDATE user_address SET province_city = :province_city, district = :district, ward_commune = :ward_commune, address = :address WHERE user_id = :user_id";
            } else {
                $sql = "INSERT INTO user_address (user_id, province_city, district, ward_commune, address) VALUES (:user_id, :province_city, :district, :ward_commune, :address)";
            }

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':user_id' => $userId,
                ':province_city' => $data['province_city'],
                ':district' => $data['district'],
                ':ward_commune' => $data['ward_commune'],
                ':address' => $data['address'],
            ]);
        } catch (\PDOException $e) {
            error_log("ProfileModel updateUserAddress error: " . $e->getMessage());
            return false;
        }
    }
}
