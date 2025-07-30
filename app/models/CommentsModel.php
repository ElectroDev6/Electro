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

    public function getAllComments(): array
    {
        try {
            $query = "
                WITH RECURSIVE comment_tree AS (
                    -- Base case: comments gốc (cmt_replie = 0)
                    SELECT 
                        c.id, c.product_id, c.user_id, c.cmt_replie, 
                        c.content, c.likes, c.status, c.created_at,
                        0 AS depth,
                        CAST(c.id AS CHAR(255)) AS path
                    FROM comments c
                    WHERE c.cmt_replie = 0
                    
                    UNION ALL
                    
                    -- Recursive case: tìm tất cả replies
                    SELECT 
                        c.id, c.product_id, c.user_id, c.cmt_replie,
                        c.content, c.likes, c.status, c.created_at,
                        ct.depth + 1,
                        CONCAT(ct.path, '->', c.id)
                    FROM comments c
                    INNER JOIN comment_tree ct ON c.cmt_replie = ct.id
                )
                SELECT 
                    ct.id,
                    ct.product_id,
                    ct.user_id,  
                    ct.cmt_replie,
                    ct.content,
                    ct.likes,
                    ct.status,
                    ct.created_at,
                    ct.depth,
                    ct.path,
                    -- Product info
                    p.id as p_id,
                    p.name as product_name,
                    p.description_html,
                    p.create_at as product_create_at,
                    p.update_date as product_update_date,
                    -- Category info
                    cat.id as category_id,
                    cat.name as category_name,
                    -- User info
                    u.username,
                    u.full_name,
                    u.phone,
                    u.role,
                    u.created_at as user_created_at
                FROM comment_tree ct
                LEFT JOIN products p ON ct.product_id = p.id
                LEFT JOIN categories cat ON p.category_id = cat.id
                LEFT JOIN users u ON ct.user_id = u.id
                ORDER BY ct.path, ct.created_at ASC
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Chuyển đổi dữ liệu thành nested structure
            return $this->buildNestedStructure($allComments);

        } catch (\PDOException $e) {
            error_log("Error fetching comments: " . $e->getMessage());
            return [];
        }
    }

    private function buildNestedStructure(array $comments): array
    {
        $commentMap = [];
        $rootComments = [];

        // Tạo map của tất cả comments với format đầy đủ
        foreach ($comments as $comment) {
            $formattedComment = [
                'id' => (int)$comment['id'],
                'product_id' => (int)$comment['product_id'],
                'product' => [
                    'id' => (int)$comment['p_id'],
                    'name' => $comment['product_name'],
                    'description_html' => $comment['description_html'],
                    'create_at' => $comment['product_create_at'],
                    'update_date' => $comment['product_update_date'],
                    'category' => [
                        'id' => (int)$comment['category_id'],
                        'name' => $comment['category_name']
                    ]
                ],
                'user_id' => (int)$comment['user_id'],
                'user' => [
                    'id' => (int)$comment['user_id'],
                    'username' => $comment['username'],
                    'full_name' => $comment['full_name'],
                    'phone' => $comment['phone'],
                    'role' => $comment['role'],
                    'created_at' => $comment['user_created_at']
                ],
                'cmt_replie' => (int)$comment['cmt_replie'],
                'content' => $comment['content'],
                'likes' => (int)$comment['likes'],
                'status' => $comment['status'],
                'created_at' => $comment['created_at'],
                'replies' => [],
                'depth' => (int)$comment['depth'],
                'path' => $comment['path']
            ];

            $commentMap[$comment['id']] = $formattedComment;
        }

        // Xây dựng nested structure
        foreach ($commentMap as $id => $comment) {
            if ($comment['depth'] == 0) {
                // Comment gốc
                $rootComments[] = &$commentMap[$id];
            } else {
                // Comment reply - thêm vào parent
                $parentId = $comment['cmt_replie'];
                if (isset($commentMap[$parentId])) {
                    $commentMap[$parentId]['replies'][] = &$commentMap[$id];
                }
            }
        }

        // Loại bỏ depth và path khỏi kết quả cuối cùng
        $this->cleanupStructure($rootComments);

        return $rootComments;
    }

    private function cleanupStructure(array &$comments): void
    {
        foreach ($comments as &$comment) {
            unset($comment['depth'], $comment['path']);
            
            if (!empty($comment['replies'])) {
                $this->cleanupStructure($comment['replies']);
            }
        }
    }

    // Alternative method: Sử dụng pure SQL approach (giống code gốc của bạn nhưng dynamic)
    public function getAllCommentsSQL(): array
    {
        try {
            // Lấy max depth để biết cần bao nhiêu cấp độ
            $maxDepthQuery = "
                WITH RECURSIVE comment_depth AS (
                    SELECT id, cmt_replie, 0 AS depth
                    FROM comments
                    WHERE cmt_replie = 0
                    UNION ALL
                    SELECT c.id, c.cmt_replie, cd.depth + 1
                    FROM comments c
                    INNER JOIN comment_depth cd ON c.cmt_replie = cd.id
                )
                SELECT MAX(depth) as max_depth FROM comment_depth
            ";
            
            $stmt = $this->pdo->prepare($maxDepthQuery);
            $stmt->execute();
            $maxDepth = $stmt->fetch(PDO::FETCH_ASSOC)['max_depth'] ?? 0;

            // Tạo dynamic query dựa trên max depth
            $repliesQuery = $this->buildDynamicRepliesQuery($maxDepth);

            $query = "
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'id', c.id,
                            'product_id', c.product_id,
                            'product', JSON_OBJECT(
                                'id', p.id,
                                'name', p.name,
                                'description_html', p.description_html,
                                'create_at', p.create_at,
                                'update_date', p.update_date,
                                'category', JSON_OBJECT(
                                    'id', cat.id,
                                    'name', cat.name
                                )
                            ),
                            'user_id', c.user_id,
                            'user', JSON_OBJECT(
                                'id', u.id,
                                'username', u.username,
                                'full_name', u.full_name,
                                'phone', u.phone,
                                'role', u.role,
                                'created_at', u.created_at
                            ),
                            'cmt_replie', c.cmt_replie,
                            'replies', $repliesQuery,
                            'content', c.content,
                            'likes', c.likes,
                            'status', c.status,
                            'created_at', c.created_at
                        )
                    ) AS comments
                FROM comments c
                LEFT JOIN products p ON c.product_id = p.id
                LEFT JOIN categories cat ON p.category_id = cat.id
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.cmt_replie = 0
                ORDER BY c.created_at DESC
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return json_decode($result['comments'] ?? '[]', true) ?: [];

        } catch (\PDOException $e) {
            error_log("Error fetching comments with SQL: " . $e->getMessage());
            return [];
        }
    }

    private function buildDynamicRepliesQuery(int $maxDepth, int $currentDepth = 1): string
    {
        if ($currentDepth > $maxDepth) {
            return 'NULL';
        }

        $nextLevel = $this->buildDynamicRepliesQuery($maxDepth, $currentDepth + 1);
        $alias = "cr" . $currentDepth;
        $userAlias = "ur" . $currentDepth;

        return "
            (
                SELECT JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', $alias.id,
                        'product_id', $alias.product_id,
                        'user_id', $alias.user_id,
                        'user', JSON_OBJECT(
                            'id', $userAlias.id,
                            'username', $userAlias.username,
                            'full_name', $userAlias.full_name,
                            'phone', $userAlias.phone,
                            'role', $userAlias.role,
                            'created_at', $userAlias.created_at
                        ),
                        'cmt_replie', $alias.cmt_replie,
                        'content', $alias.content,
                        'likes', $alias.likes,
                        'status', $alias.status,
                        'created_at', $alias.created_at,
                        'replies', $nextLevel
                    )
                )
                FROM comments $alias
                LEFT JOIN users $userAlias ON $alias.user_id = $userAlias.id
                WHERE $alias.cmt_replie = " . ($currentDepth == 1 ? "c.id" : "cr" . ($currentDepth - 1) . ".id") . "
                ORDER BY $alias.created_at ASC
            )
        ";
    }


    public function getNestedCommentsJson(): string
    {
        $comments = $this->getAllComments();
        return json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
?>