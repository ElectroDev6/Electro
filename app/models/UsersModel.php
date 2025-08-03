<?php
namespace App\Models;

use PDO;

class UsersModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAllUsers()
    {
        $sql = "
            SELECT 
                u.id,
                u.username,
                u.full_name,
                u.phone,
                u.role,
                u.created_at,
                u.password,
                ua.id as address_id,
                ua.address_line,
                ua.ward,
                ua.district,
                ua.city,
                ua.created_at as address_created_at
            FROM users u
            LEFT JOIN user_addresses ua ON ua.user_id = u.id
            WHERE ua.id = (
                SELECT MIN(ua2.id) 
                FROM user_addresses ua2 
                WHERE ua2.user_id = u.id
            )
            OR ua.id IS NULL
            ORDER BY u.id
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }


    public function updateUser($data) {
    $fields = [
        'username' => $data['username'],
        'email' => $data['email'],
        'full_name' => $data['full_name'],
        'phone' => $data['phone'],
        'sex' => $data['sex'],
        'role' => $data['role'],
    ];

    $sql = "UPDATE users SET ";
    $set = [];
    foreach ($fields as $key => $val) {
        $set[] = "$key = :$key";
    }

    if ($data['password']) {
        $set[] = "password = :password";
        $fields['password'] = $data['password'];
    }

    $sql .= implode(', ', $set) . " WHERE id = :id";
    $fields['id'] = $data['id'];

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($fields);
}   

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, full_name, phone, role, sex, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser(array $data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, full_name, phone, role, sex, password, created_at)
            VALUES (:username, :email, :full_name, :phone, :role, :sex, :password, NOW())
        ");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':role' => $data['role'],
            ':sex' => $data['sex'],
            ':password' => $data['password'],
        ]);
    }




}
?>