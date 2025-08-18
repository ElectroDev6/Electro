<?php

namespace App\Models\admin;

use PDO;
use PDOException;

class UsersModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers($filters = [], $limit = 8, $offset = 0)
    {
        $whereConditions = [];
        $params = [];
        if (!empty($filters['search'])) {
            $whereConditions[] = "(name LIKE :search OR email LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['role'])) {
            $whereConditions[] = "role = :role";
            $params[':role'] = $filters['role'];
        }

        if (!empty($filters['gender'])) {
            $whereConditions[] = "gender = :gender";
            $params[':gender'] = $filters['gender'];
        }
        $whereClause = '';
        if (!empty($whereConditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
        }
        $query = "SELECT * FROM users 
                  $whereClause 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers($filters = [])
    {
        $whereConditions = [];
        $params = [];
        if (!empty($filters['search'])) {
            $whereConditions[] = "(name LIKE :search OR email LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['role'])) {
            $whereConditions[] = "role = :role";
            $params[':role'] = $filters['role'];
        }
        if (!empty($filters['gender'])) {
            $whereConditions[] = "gender = :gender";
            $params[':gender'] = $filters['gender'];
        }
        $whereClause = '';
        if (!empty($whereConditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
        }
        $query = "SELECT COUNT(*) as total FROM users $whereClause";
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public function userExistsByEmail($email, $id = null)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        if ($id !== null) {
            $sql .= " AND user_id != :id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if ($id !== null) {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function createUser($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, phone_number, gender, role, is_active, password_hash, avatar_url, created_at, updated_at) 
                                    VALUES (:name, :email, :phone_number, :gender, :role, :is_active, :password_hash, :avatar_url, NOW(), NOW())");
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':gender' => $data['gender'],
            ':role' => $data['role'],
            ':is_active' => $data['is_active'],
            ':password_hash' => $data['password_hash'],
            ':avatar_url' => $data['avatar_url'],
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT u.*, ua.address, ua.ward_commune, ua.district, ua.province_city
            FROM users u
            LEFT JOIN user_address ua ON u.user_id = ua.user_id
            WHERE u.user_id = :id
            LIMIT 1
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

   public function deleteUser($id)
    {
        try {
            $stmtOrders = $this->pdo->prepare("DELETE FROM orders WHERE user_address_id IN (SELECT user_address_id FROM user_address WHERE user_id = :id)");
            $stmtOrders->execute([':id' => $id]);

            // Xóa địa chỉ người dùng
            $stmtAddress = $this->pdo->prepare("DELETE FROM user_address WHERE user_id = :id");
            $stmtAddress->execute([':id' => $id]);

            // Xóa người dùng
            $stmtUser = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
            $stmtUser->execute([':id' => $id]);

            return true;
        } catch (PDOException $e) {
            // Trả về false hoặc thông báo lỗi
            return false; // Hoặc: throw new Exception("Lỗi khi xóa: " . $e->getMessage());
        }
    }

    public function updateUser($user_id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET name = :name, email = :email, phone_number = :phone_number, 
                gender = :gender, role = :role, is_active = :is_active, 
                avatar_url = :avatar_url,
                updated_at = NOW()
            WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':user_id' => $user_id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'] ?: null,
            ':gender' => $data['gender'] ?: null,
            ':role' => $data['role'],
            ':is_active' => $data['is_active'],
            ':avatar_url' => $data['avatar_url'] ?? null,
        ]);
    }

    public function updateAddress($user_id, $data)
    {
        $stmt = $this->pdo->prepare("SELECT user_address_id FROM user_address WHERE user_id = :user_id LIMIT 1");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $addressExists = $stmt->fetchColumn();

        if ($addressExists) {
            $stmt = $this->pdo->prepare("
                UPDATE user_address 
                SET address = :address, ward_commune = :ward_commune, 
                    district = :district, province_city = :province_city, 
                    updated_at = NOW()
                WHERE user_id = :user_id
            ");
        } else {
            $stmt = $this->pdo->prepare("
                INSERT INTO user_address (user_id, address, ward_commune, district, province_city, created_at, updated_at)
                VALUES (:user_id, :address, :ward_commune, :district, :province_city, NOW(), NOW())
            ");
        }
        return $stmt->execute([
            ':user_id' => $user_id,
            ':address' => $data['address'],
            ':ward_commune' => $data['ward_commune'],
            ':district' => $data['district'],
            ':province_city' => $data['province_city'],
        ]);
    }

    public function getUserActiveOrders($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM orders 
            WHERE user_id = :id 
            AND status IN ('processing', 'shipped', 'paid')
        ");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchColumn();
    }

    public function toggleUserLock($userId)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET is_active = CASE WHEN is_active = 1 THEN 0 ELSE 1 END 
            WHERE user_id = :user_id
        ");
        return $stmt->execute([':user_id' => $userId]);
    }
}