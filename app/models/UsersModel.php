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

    public function getAllUsers(): array
    {
        $sql = "
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', u.id,
                        'username', u.username,
                        'full_name', u.full_name,
                        'phone', u.phone,
                        'role', u.role,
                        'created_at', u.created_at,
                        'address', (
                            SELECT JSON_OBJECT(
                                'id', ua.id,
                                'address_line', ua.address_line,
                                'ward', ua.ward,
                                'district', ua.district,
                                'city', ua.city,
                                'created_at', ua.created_at
                            )
                            FROM user_addresses ua
                            WHERE ua.user_id = u.id
                            LIMIT 1
                        )
                    )
                ) AS users
            FROM users u
        ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $users = json_decode($result['users'], true) ?: [];
            return $users;
       
    }
}
?>