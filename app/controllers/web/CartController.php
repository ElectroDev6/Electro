<?php

namespace App\Controllers\Web;

use Core\View;
use App\Services\CartService;

class CartController
{
    protected CartService $cartService;
    protected int $userId = 1; // Giả lập user, có thể dùng session

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index()
    {
        $cartData = $this->cartService->getCartWithSummary($this->userId);

        // Nếu giỏ hàng rỗng thì vẫn đảm bảo phần summary có giá trị mặc định
        if (empty($cartData['products'])) {
            $cartData['summary'] = [
                'total_price' => 0,
                'total_discount' => 0,
                'shipping_fee' => 0,
                'final_total' => 0,
            ];
        }

        View::render('cart', ['cart' => $cartData]);
    }

    public function updateQuantity()
    {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        if ($productId && $quantity) {
            $this->cartService->updateQuantity($this->userId, (int)$productId, (int)$quantity);
        }

        header('Location: /cart');
        exit;
    }

    public function delete()
    {
        $productId = $_POST['product_id'] ?? null;

        if ($productId) {
            $this->cartService->removeFromCart($this->userId, (int)$productId);
        }

        header('Location: /cart');
        exit;
    }

    public function add()
    {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($productId) {
            $this->cartService->addToCart($this->userId, (int)$productId, (int)$quantity);
        }

        header('Location: /cart');
        exit;
    }

    public function selectAll()
    {
        $this->cartService->selectAll($this->userId);
        header('Location: /cart');
        exit;
    }

    public function unselectAll()
    {
        $this->cartService->unselectAll($this->userId);
        header('Location: /cart');
        exit;
    }

    public function toggleSelect()
    {
        $productId = $_POST['product_id'] ?? null;
        $selected = isset($_POST['selected']) && $_POST['selected'] === '1';

        if ($productId !== null) {
            $this->cartService->toggleSelect($this->userId, (int)$productId, $selected);
        }

        header('Location: /cart');
        exit;
    }

    public function toggleWarranty()
    {
        $productId = $_POST['product_id'] ?? null;
        $enabled = isset($_POST['enabled']) && $_POST['enabled'] === '1';

        if ($productId !== null) {
            $this->cartService->toggleWarranty($this->userId, (int)$productId, $enabled);
        }

        header('Location: /cart');
        exit;
    }

    public function updateColor()
    {
        $productId = $_POST['product_id'] ?? null;
        $color = $_POST['color'] ?? null;

        if ($productId && $color) {
            $this->cartService->updateColor($this->userId, (int)$productId, $color);
        }

        header('Location: /cart');
        exit;
    }
}
