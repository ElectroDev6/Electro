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

        // Bind filter parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // Bind pagination parameters
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
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, phone_number, gender, birth_date, role, is_active, password_hash, avatar_url, created_at, updated_at) 
                                    VALUES (:name, :email, :phone_number, :gender, :birth_date, :role, :is_active, :password_hash, :avatar_url, NOW(), NOW())");
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':gender' => $data['gender'],
            ':birth_date' => $data['birth_date'],
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
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !$user['address']) {
            $stmt = $this->pdo->prepare("
                SELECT address, ward_commune, district, province_city
                FROM user_address
                WHERE user_id = :id
                LIMIT 1
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $address = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($address) {
                $user['address'] = $address['address'];
                $user['ward_commune'] = $address['ward_commune'];
                $user['district'] = $address['district'];
                $user['province_city'] = $address['province_city'];
            }
        }
        return $user;
    }
    public function deleteUser($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }
    public function updateUser($user_id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET name = :name, email = :email, phone_number = :phone_number, gender = :gender, 
                birth_date = :birth_date, role = :role, is_active = :is_active, 
                avatar_url = :avatar_url, updated_at = NOW()
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'] ?: null,
            ':gender' => $data['gender'],
            ':birth_date' => $data['birth_date'],
            ':role' => $data['role'],
            ':is_active' => $data['is_active'],
            ':avatar_url' => $data['avatar_url'] ?? null,
        ]);
    }
    public function updateAddress($user_id, $data)
    {
        $stmt = $this->pdo->prepare("SELECT user_address_id FROM user_address WHERE user_id = :user_id AND is_default = 1 LIMIT 1");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $addressExists = $stmt->fetchColumn();
        if ($addressExists) {
            $stmt = $this->pdo->prepare("
                UPDATE user_address 
                SET address = :address, ward_commune = :ward_commune, 
                    district = :district, province_city = :province_city, 
                    updated_at = NOW()
                WHERE user_id = :user_id AND is_default = 1
            ");
        } else {
            $stmt = $this->pdo->prepare("
                INSERT INTO user_address (user_id, address, ward_commune, district, province_city, is_default, created_at, updated_at)
                VALUES (:user_id, :address, :ward_commune, :district, :province_city, 1, NOW(), NOW())
            ");
        }
        $stmt->execute([
            ':user_id' => $user_id,
            ':address' => $data['address'] ?? null,
            ':ward_commune' => $data['ward_commune'] ?? null,
            ':district' => $data['district'] ?? null,
            ':province_city' => $data['province_city'] ?? null,
        ]);
    }
}
