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
}
?>