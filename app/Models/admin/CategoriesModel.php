<?php
namespace App\Models\admin;

use PDO;
use PDOException;

class CategoriesModel
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function fetchAllCategories()
    {
        $sql = "
            SELECT 
                c.category_id,
                c.name,
                c.image,
                c.description,
                c.slug,
                c.created_at,
                c.updated_at,
                COUNT(p.product_id) as product_count
            FROM categories c
            LEFT JOIN subcategories s ON c.category_id = s.category_id
            LEFT JOIN products p ON s.subcategory_id = p.subcategory_id
            GROUP BY c.category_id, c.name, c.image, c.description, c.slug, c.created_at, c.updated_at
            ORDER BY c.category_id ASC
        ";

        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching categories: ' . $e->getMessage());
            return [];
        }
    }

    public function getCategoriesStats()
    {
        try {
            // Lấy tổng số sản phẩm từ tất cả categories thông qua subcategories
            $sql = "
                SELECT 
                    COUNT(DISTINCT c.category_id) as total_categories,
                    COUNT(DISTINCT p.product_id) as total_products,
                    COUNT(DISTINCT c.category_id) as active_categories
                FROM categories c
                LEFT JOIN subcategories s ON c.category_id = s.category_id
                LEFT JOIN products p ON s.subcategory_id = p.subcategory_id
            ";
            
            $stmt = $this->pdo->query($sql);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'total_categories' => (int)$stats['total_categories'],
                'total_products' => (int)$stats['total_products'],
                'active_categories' => (int)$stats['active_categories'],
                'display_rate' => $stats['total_categories'] > 0 ? 100 : 0
            ];
        } catch (PDOException $e) {
            error_log('Error fetching category stats: ' . $e->getMessage());
            return [
                'total_categories' => 0,
                'total_products' => 0,
                'active_categories' => 0,
                'display_rate' => 0
            ];
        }
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE category_id = :id";
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
            if ($value !== null && in_array($key, ['name', 'description', 'image'])) {
                $updates[] = "$key = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $sql = "UPDATE categories SET " . implode(', ', $updates) . ", updated_at = NOW() WHERE category_id = :id";

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
        $sql = "INSERT INTO categories (name, description, slug, image, created_at, updated_at)
                VALUES (:name, :description, :slug, :image, NOW(), NOW())";
        try {
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                ':name' => $data['name'] ?? null,
                ':description' => $data['description'] ?? null,
                ':slug' => $data['slug'] ?? null,
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
        try {
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE category_id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }

    public function categoryExistsByName($name, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE LOWER(name) = LOWER(:name)";
        $params = ['name' => $name];
        if ($excludeId !== null) {
            $sql .= " AND category_id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }


    public function getSubcategories($categoryId) {
        try {
            $stmt = $this->pdo->prepare("SELECT subcategory_id, name FROM subcategories WHERE category_id = ?");
            $stmt->execute([$categoryId]);
            $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $subcategories;
        } catch (PDOException $e) {
            return ['error' => 'Lỗi truy vấn: ' . $e->getMessage()];
        }
    }
}