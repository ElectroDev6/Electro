<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use App\Services\CartService;
use Core\View;

class DetailController
{
    private $productService;
    private $cartService;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo);
        $this->productService = new ProductService($pdo, $this->cartService);
    }

    public function showDetail($params)
    {
        $slug = $params['matches']['slug'] ?? null;

        if (!$slug) {
            header('Location: /products');
            exit;
        }

        $product = $this->productService->getProductDetail($slug);
        $relatedProducts = $this->productService->relatedProducts(
            $product['subcategory_id'],
            $product['product_id'],
            5
        );

        $reviews = $this->productService->getReviews($product['product_id']);
        // echo "<pre>";
        // print_r($product);
        // echo "</pre>";
        // exit();
        View::render('detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews
        ]);
    }

    public function addToCart($input = [], $matches = [])
    {
        error_log("DetailController: Entered addToCart, Input: " . json_encode($input));

        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            error_log("DetailController: Not an AJAX request");
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
            return;
        }

        $body = $input['body'] ?? [];
        $skuId = $body['sku_id'] ?? null;
        $productId = $body['product_id'] ?? null;
        $quantity = (int)($body['quantity'] ?? 1);
        $color = $body['color'] ?? null;
        $warrantyEnabled = isset($body['warranty_enabled']) ? (bool)$body['warranty_enabled'] : false;
        $imageUrl = $body['image_url'] ?? null;

        // Nếu chỉ có product_id, lấy SKU mặc định
        if (!$skuId && $productId) {
            $sku = $this->productService->getDefaultSkuByProductId($productId);
            if (!$sku) {
                error_log("DetailController: No default SKU found for product_id: $productId");
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy SKU mặc định.']);
                return;
            }
            $skuId = $sku['sku_id'];
            $color = $sku['color'] ?? $color;
            $imageUrl = $sku['image_url'] ?? $imageUrl;
        }

        error_log("DetailController: Parsed - SKU: " . ($skuId ?? 'null') . ", Product ID: " . ($productId ?? 'null') . ", Quantity: $quantity, Color: " . ($color ?? 'null') . ", Warranty: " . ($warrantyEnabled ? 'true' : 'false') . ", Image: " . ($imageUrl ?? 'null'));

        if (!$skuId) {
            error_log("DetailController: SKU is invalid or null");
            echo json_encode(['success' => false, 'message' => 'SKU không hợp lệ.']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        error_log("DetailController: User ID: " . ($userId ?? 'null') . ", Session ID: " . ($sessionId ?? 'null'));

        $result = $this->productService->addToCart($skuId, $quantity, $userId, $sessionId, $color, $warrantyEnabled, $imageUrl);
        error_log("DetailController: Add to cart result: " . json_encode($result));

        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function addComment($input)
    {
        $product_id = $input['product_id'] ?? null;
        $parent_review_id = $input['parent_review_id'] ? (int)$input['parent_review_id'] : null; // Chuyển chuỗi rỗng thành null
        $comment_text = $input['comment_text'] ?? '';
        $user_name = $input['user_name'] ?? null;
        $email = $input['email'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$product_id || !$comment_text) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        if (!$user_id && (!$user_name || !$email)) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and email required for guests']);
            return;
        }

        $result = $this->productService->addReview(
            $product_id,
            $user_id,
            $parent_review_id,
            $comment_text,
            $user_name,
            $email
        );

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add comment']);
        }
    }
}
