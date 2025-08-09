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
        // echo "<pre>";
        // print_r($relatedProducts);   
        // echo "</pre>";
        // exit;
        View::render('detail', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }

    public function showCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $cart = $this->cartService->getCart($userId, $sessionId);
        View::render('cart', ['cart' => $cart]);
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
        $quantity = $input['quantity'] ?? 1;

        error_log("DetailController: Received SKU ID: " . ($skuId ?? 'null') . ", Quantity: " . $quantity);

        if (!$skuId) {
            error_log("DetailController: SKU is invalid or null, Input: " . json_encode($input));
            echo json_encode(['success' => false, 'message' => 'SKU không hợp lệ.']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        error_log("DetailController: User ID: " . ($userId ?? 'null') . ", Session ID: " . ($sessionId ?? 'null'));

        $result = $this->productService->addToCart($skuId, $quantity, $userId, $sessionId);
        error_log("DetailController: Add to cart result: " . json_encode($result));

        if ($result['success']) {
            // Trả về redirect thay vì chỉ JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $result['message'],
                'redirect' => '/cart'
            ]);
        } else {
            echo json_encode($result);
        }
    }
}
