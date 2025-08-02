<?php
namespace App\Models;

use PDO;
use PDOException;

class CategoriesModel
{
    private $pdo;
    private string $table = 'categories';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAllCategories()
    {
        $sql = "
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', c.id,
                        'name', c.name,
                        'image', c.image,
                        'create_at', c.create_at,
                        'content_html', c.content_html,
                        'total_products', c.total_products
                    )
                ) AS categories
            FROM {$this->table} c
        ";

        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return json_decode($result['categories'] ?? '[]', true);
        } catch (PDOException $e) {
            error_log('Error fetching categories: ' . $e->getMessage());
            return [];
        }
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('Error fetching category by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function updateCategory(int $id, array $data)
    {
        if (empty($data)) {
            return false;
        }

        $updates = [];
        $params = [':id' => $id];
        foreach ($data as $key => $value) {
            if ($value !== null && in_array($key, ['name', 'content_html', 'image'])) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $updates) . ", update_date = NOW() WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Error updating category: ' . $e->getMessage());
            return false;
        }
    }

    public function createCategory(array $data)
    {
        $sql = "INSERT INTO {$this->table} (name, content_html, image, create_at, update_date)
                VALUES (:name, :content_html, :image, NOW(), NOW())";

        try {
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                ':name' => $data['name'] ?? null,
                ':content_html' => $data['content_html'] ?? null,
                ':image' => $data['image'] ?? null
            ]);

            return $success ? (int)$this->pdo->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log('Error creating category: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


    public function categoryExistsByName($name, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE LOWER(name) = LOWER(:name)";
        $params = ['name' => $name];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

}
?>