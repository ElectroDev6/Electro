<?php

namespace App\Controllers\Web;

use App\Services\CartService;
use Core\View;

class CartController
{
    private $cartService;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo);
    }

    public function showCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $cart = $this->cartService->getCart($userId, $sessionId);
        View::render('cart', ['cart' => $cart]);
    }

    public function addToCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['sku_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        $color = $_POST['color'] ?? null;
        $warrantyEnabled = isset($_POST['warranty_enabled']) && $_POST['warranty_enabled'] === 'true';
        $imageUrl = $_POST['image_url'] ?? null;

        if ($skuId) {
            $result = $this->cartService->addToCart($skuId, $quantity, $userId, $sessionId, $color, $warrantyEnabled, $imageUrl);
            return $result;
        }
        return ['success' => false, 'message' => 'Invalid product ID.'];
    }

    public function getCartItemCount()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $count = $this->cartService->getCartItemCount($userId, $sessionId);
        return ['success' => true, 'count' => $count];
    }

    public function selectAll()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $selectAll = isset($_POST['select_all']) && $_POST['select_all'] === 'on';
        $this->cartService->updateSelectAll($userId, $sessionId, $selectAll);
        header('Location: /cart');
        exit;
    }

    public function selectProduct()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['sku_id'] ?? null;
        $selected = isset($_POST['selected']) && $_POST['selected'] === 'on';
        if ($skuId) {
            $this->cartService->updateProductSelection($userId, $sessionId, $skuId, $selected);
        }
        header('Location: /cart');
        exit;
    }

    public function updateColor()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['product_id'] ?? null;
        $color = $_POST['color'] ?? null;
        if ($skuId && $color) {
            $this->cartService->updateProductColor($userId, $sessionId, $skuId, $color);
        }
        header('Location: /cart');
        exit;
    }

    public function updateQuantity()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        if ($skuId && $quantity > 0) {
            $this->cartService->updateQuantity($userId, $sessionId, $skuId, $quantity);
        }
        header('Location: /cart');
        exit;
    }

    public function updateWarranty()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['product_id'] ?? null;
        $enabled = isset($_POST['warranty']) && $_POST['warranty'] === 'on';
        if ($skuId) {
            $this->cartService->updateWarranty($userId, $sessionId, $skuId, $enabled);
        }
        header('Location: /cart');
        exit;
    }

    public function delete()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $skuId = $_POST['product_id'] ?? null;

        if ($skuId) {
            $this->cartService->removeProductFromCart($skuId, $userId, $sessionId);
        }

        header('Location: /cart');
        exit;
    }

    public function applyVoucher()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $voucherCode = $_POST['voucher_code'] ?? null;
        $result = $this->cartService->applyVoucher($userId, $sessionId, $voucherCode);
        return $result;
    }

    public function confirmOrder()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $result = $this->cartService->confirmOrder($userId, $sessionId);
        if ($result['success']) {
            header('Location: /checkout');
            exit;
        }
        return $result;
    }
}
