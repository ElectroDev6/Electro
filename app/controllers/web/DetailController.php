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

    public function showDetail($slug)
    {
        $product = $this->productService->getProductService($slug);
        $relatedProducts = $this->productService->relatedProducts(
            $product['category_id'],
            $product['product_id'],
            5
        );
        $reviews = $this->productService->getReviews($product['product_id']);

        View::render('detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews
        ]);
    }

    public function addToCart($input = [], $matches = [])
    {
        error_log("DetailController: Entered addToCart, Input: " . json_encode($input) . ", Matches: " . json_encode($matches));

        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            error_log("DetailController: Not an AJAX request");
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
            return;
        }

        $skuId = $input['sku_id'] ?? null;
        $quantity = (int)($input['quantity'] ?? 1);
        $color = $input['color'] ?? null;
        $warrantyEnabled = isset($input['warranty_enabled']) ? (bool)$input['warranty_enabled'] : false;
        $imageUrl = $input['image_url'] ?? null;

        error_log("DetailController: Parsed - SKU: " . ($skuId ?? 'null') . ", Quantity: $quantity, Color: " . ($color ?? 'null') . ", Warranty: " . ($warrantyEnabled ? 'true' : 'false') . ", Image: " . ($imageUrl ?? 'null'));

        if (!$skuId) {
            error_log("DetailController: SKU is invalid or null, Input: " . json_encode($input));
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
        $rating = $input['rating'] ? (int)$input['rating'] : null; // Chuyển rating thành int
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
            $rating,
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
