<?php
namespace App\Models;
use PDO;

class CommentsModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllComments()
    {
        try {
            $query = "
                SELECT 
                    c.id,
                    c.product_id,
                    c.user_id,
                    c.cmt_replie,
                    c.content,
                    c.likes,
                    c.status,
                    c.created_at,
                    p.id AS p_id,
                    p.name AS product_name,
                    p.description_html,
                    p.create_at AS product_create_at,
                    p.update_date AS product_update_date,
                    cat.id AS category_id,
                    cat.name AS category_name,
                    u.username,
                    u.full_name,
                    u.phone,
                    u.role,
                    u.created_at AS user_created_at
                FROM comments c
                LEFT JOIN products p ON c.product_id = p.id
                LEFT JOIN categories cat ON p.category_id = cat.id
                LEFT JOIN users u ON c.user_id = u.id
                ORDER BY 
                    CASE WHEN c.cmt_replie = 0 THEN c.id ELSE c.cmt_replie END,
                    c.cmt_replie,
                    c.created_at ASC
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->buildNestedStructure($comments);
        } catch (\PDOException $e) {
            error_log("Error fetching comments: " . $e->getMessage());
            return [];
        }
    }

    private function buildNestedStructure($comments)
    {
        $commentMap = [];
        $rootComments = [];

        // Tạo map của tất cả comments
        foreach ($comments as $comment) {
            $formattedComment = [
                'id' => $comment['id'],
                'product_id' => $comment['product_id'],
                'product' => [
                    'id' => $comment['p_id'],
                    'name' => $comment['product_name'],
                    'description_html' => $comment['description_html'],
                    'create_at' => $comment['product_create_at'],
                    'update_date' => $comment['product_update_date'],
                    'category' => [
                        'id' => $comment['category_id'],
                        'name' => $comment['category_name']
                    ]
                ],
                'user_id' => $comment['user_id'],
                'user' => [
                    'id' => $comment['user_id'],
                    'username' => $comment['username'],
                    'full_name' => $comment['full_name'],
                    'phone' => $comment['phone'],
                    'role' => $comment['role'],
                    'created_at' => $comment['user_created_at']
                ],
                'cmt_replie' => $comment['cmt_replie'],
                'content' => $comment['content'],
                'likes' => $comment['likes'],
                'status' => $comment['status'],
                'created_at' => $comment['created_at'],
                'replies' => []
            ];

            $commentMap[$comment['id']] = $formattedComment;
        }
        foreach ($commentMap as $id => $comment) {
            if ($comment['cmt_replie'] == 0) {
                // Comment gốc (cmt_replie = 0)
                $rootComments[] = &$commentMap[$id];
            } else {
                // Comment reply - thêm vào parent
                $parentId = $comment['cmt_replie'];
                if (isset($commentMap[$parentId])) {
                    $commentMap[$parentId]['replies'][] = &$commentMap[$id];
                }
            }
        }
        
        return $rootComments;
    }

    

    public function deleteComment($id)
    {
        try {
            if ($id === null) {
                error_log("Delete failed: Comment ID is null");
                return false;
            }

            $sql = "DELETE FROM comments WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result && $stmt->rowCount() > 0) {
                return true;
            }
            
            error_log("Delete failed: No record found for ID $id");
            return false;
        } catch (\PDOException $e) {
            error_log("Error deleting comment: " . $e->getMessage());
            return false;
        }
    }


    public function update($id, $data)
    {
        try {
            $set = [];
            $params = [':id' => $id];
            
            foreach ($data as $key => $value) {
                $set[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            
            $sql = "UPDATE comments SET " . implode(', ', $set) . " WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);

            return $result;
        } catch (PDOException $e) {
            error_log("Error updating comment: " . $e->getMessage());
            return false;
        }
    }


    public function getCommentById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching comment: " . $e->getMessage());
            return false;
        }
    }


public function createCommentReply($data) {
        try {
            $sql = "INSERT INTO comments (
                product_id,
                user_id,
                cmt_replie,
                content,
                likes,
                status,
                created_at
            ) VALUES (
                :product_id,
                :user_id,
                :cmt_replie,
                :content,
                :likes,
                :status,
                :created_at
            )";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':cmt_replie', $data['cmt_replie'], PDO::PARAM_INT);
            $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindParam(':likes', $data['likes'], PDO::PARAM_INT);
            $stmt->bindParam(':status', $data['status'], PDO::PARAM_STR);
            $stmt->bindParam(':created_at', $data['created_at'], PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }



}
?>