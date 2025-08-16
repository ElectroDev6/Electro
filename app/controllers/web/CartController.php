<?php

namespace App\Controllers\Web;

use App\Services\CartService;
use Core\View;

class CartController
{
    private $cartService;
    private ?int $userId;
    private string $sessionId;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo);
        $this->userId = $_SESSION['user_id'] ?? null;
        $this->sessionId = session_id();
    }

    public function showCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $cart = $this->cartService->getCart($userId, $sessionId);
        View::render('cart', ['cart' => $cart]);
    }

    public function getCartItemCount()
    {
        header('Content-Type: application/json');
        $count = $this->cartService->getCartItemCount($this->userId, $this->sessionId);
        echo json_encode(['success' => true, 'count' => $count]);
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
        error_log("CartController: Applying voucher - Voucher: " . ($voucherCode ?? 'null') . ", UserID: " . ($userId ?? 'null') . ", SessionID: $sessionId");

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if (!$voucherCode) {
            $result = ['success' => false, 'message' => 'Vui lòng nhập mã voucher.'];
        } else {
            $result = $this->cartService->applyVoucher($userId, $sessionId, $voucherCode);
        }

        $_SESSION['voucher_message'] = $result['message'];

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }

        header('Location: /cart');
        exit;
    }

    public function confirmOrder()
    {
        $isAjax = $this->isAjax();
        error_log("CartController: Confirming order - UserID: $this->userId, SessionID: $this->sessionId, IsAjax: " . var_export($isAjax, true));

        if (!$this->userId) {
            $_SESSION['post_login_redirect'] = '/checkout';
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục thanh toán.', 'redirect' => '/login']);
                exit;
            }
            header('Location: /login');
            exit;
        }

        $result = $this->cartService->confirmOrder($this->userId, $this->sessionId);

        if ($result) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Xác nhận đơn hàng thành công.', 'redirect' => '/checkout']);
                exit;
            }
            header('Location: /checkout');
            exit;
        } else {
            $_SESSION['error_message'] = 'Không thể xác nhận đơn hàng. Vui lòng thử lại.';
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không thể xác nhận đơn hàng. Vui lòng thử lại.', 'redirect' => '/cart']);
                exit;
            }
            header('Location: /cart');
            exit;
        }
    }

    /**
     * Kiểm tra xem yêu cầu có phải AJAX không
     * @return bool
     */
    private function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
