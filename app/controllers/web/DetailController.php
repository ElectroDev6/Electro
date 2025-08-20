<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use App\Services\CartService;
use App\Services\WishlistService;
use Core\View;

class DetailController
{
    private $productService;
    private $cartService;
    private $wishlistService;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo);
        $this->productService = new ProductService($pdo, $this->cartService);
        $this->wishlistService = new WishlistService($pdo);
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
            'reviews' => $reviews,
            'is_in_wishlist' =>  $this->wishlistService->isProductInWishlist($_SESSION['user_id'], $product['product_id'])
        ]);
    }

    public function toggleWishlist()
    {
        // Kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm vào wishlist.']);
            exit;
        }

        // Lấy product_id từ POST
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        if ($productId <= 0) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ.']);
            exit;
        }

        // Toggle wishlist
        $result = $this->wishlistService->toggleWishlist($_SESSION['user_id'], $productId);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
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
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Bạn cần đăng nhập để gửi bình luận']);
            return;
        }

        $body = $input['body'] ?? [];

        $product_id = isset($body['product_id']) ? (int)$body['product_id'] : null;
        $comment_text = $body['comment_text'] ?? '';
        $user_id = $_SESSION['user_id'];

        $parent_review_id = null;
        if (isset($body['parent_review_id']) && $body['parent_review_id'] !== '') {
            $parent_review_id = (int)$body['parent_review_id'];
        }

        if (!$product_id || $product_id <= 0 || !$comment_text) {
            http_response_code(400);
            error_log("DetailController: Invalid input - product_id: $product_id, comment_text: $comment_text");
            echo json_encode(['error' => 'Thiếu hoặc không hợp lệ: product_id hoặc comment_text']);
            return;
        }

        $result = $this->productService->addReview(
            $product_id,
            $user_id,
            $parent_review_id,
            $comment_text
        );

        if ($result) {
            $userName = $this->productService->getUserById($user_id);
            // Lấy review_id vừa tạo (giả sử addReview trả về ID mới)
            $new_review_id = $this->productService->getLastInsertId(); // Cần thêm phương thức này
            echo json_encode(['success' => true, 'review_id' => $new_review_id, 'user_name' => $userName['name']]);
        } else {
            http_response_code(500);
            error_log("DetailController: Failed to add review for product_id: $product_id, user_id: $user_id");
            echo json_encode(['error' => 'Không thể thêm bình luận']);
        }
    }
}
