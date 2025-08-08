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
        error_log("CartController: UserID: " . ($userId ?? 'null') . ", SessionID: $sessionId");
        
        $cart = $this->cartService->getCart($userId, $sessionId);

        // Remove debug code for production
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // exit;

        View::render('cart', ['cart' => $cart]);
    }

    public function addToCart()
    {
        // Handle AJAX or form submission for adding items
        $skuId = $_POST['sku_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);

        if (!$skuId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
            return;
        }

        if ($quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Số lượng không hợp lệ']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        $result = $this->cartService->addToCart($skuId, $quantity, $userId, $sessionId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // AJAX request
            echo json_encode($result);
        } else {
            // Regular form submission
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header('Location: /cart');
            exit;
        }
    }

    public function delete()
    {
        $skuId = $_POST['product_id'] ?? $_POST['sku_id'] ?? null; // Support both parameter names
        
        if (!$skuId) {
            $response = ['success' => false, 'message' => 'Thiếu thông tin sản phẩm'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            } else {
                $_SESSION['error_message'] = $response['message'];
                header('Location: /cart');
                exit;
            }
        }
    
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        $result = $this->cartService->removeFromCart($skuId, $userId, $sessionId);
        
        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header('Location: /cart');
            exit;
        }
    }

    public function updateProductQuantity()
    {
        $skuId = $_POST['product_id'] ?? $_POST['sku_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        if (!$skuId || $quantity === null) {
            $response = ['success' => false, 'message' => 'Thiếu thông tin sản phẩm hoặc số lượng'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            } else {
                $_SESSION['error_message'] = $response['message'];
                header('Location: /cart');
                exit;
            }
        }

        // Chuyển đổi về kiểu int
        $quantity = (int)$quantity;

        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        $result = $this->cartService->updateCartItemQuantity($userId, $sessionId, $skuId, $quantity);
        
        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header('Location: /cart');
            exit;
        }
    }

    public function updateQuantity()
    {
        // Alias cho updateProductQuantity để tương thích
        return $this->updateProductQuantity();
    }

    public function toggleSelectAll()
{
    $isSelected = isset($_POST['selected']) ? (bool)$_POST['selected'] : false;

    $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
    $sessionId = $_COOKIE['session_id'] ?? session_id();

    // Lấy danh sách sản phẩm trong giỏ
    $cartItems = $this->cartService->getCartItems($userId, $sessionId);
    $skuIds = array_column($cartItems, 'sku_id');

    if ($isSelected) {
        // Chọn tất cả
        $_SESSION['cart_selected'] = $skuIds;
        $message = 'Đã chọn tất cả sản phẩm.';
    } else {
        // Bỏ chọn tất cả
        $_SESSION['cart_selected'] = [];
        $message = 'Đã bỏ chọn tất cả sản phẩm.';
    }

    $result = ['success' => true, 'message' => $message];

    if ($this->isAjaxRequest()) {
        echo json_encode($result);
        return;
    } else {
        $_SESSION['success_message'] = $message;
        header('Location: /cart');
        exit;
    }
}


    public function updateSelection()
    {
        $skuId = $_POST['product_id'] ?? $_POST['sku_id'] ?? null;
        $selected = isset($_POST['selected']) ? (bool)$_POST['selected'] : false;

        if (!$skuId) {
            $response = ['success' => false, 'message' => 'Thiếu thông tin sản phẩm'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            }
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = $_COOKIE['session_id'] ?? session_id();

        $result = $this->cartService->updateItemSelection($skuId, $selected, $userId, $sessionId);
        
        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header("Location: /cart");
            exit;
        }
    }

    public function updateColor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response = ['success' => false, 'message' => 'Phương thức không hợp lệ.'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            } else {
                $_SESSION['error_message'] = $response['message'];
                header('Location: /cart');
                exit;
            }
        }

        $skuId = $_POST['current_sku_id'] ?? $_POST['sku_id'] ?? null;
        $colorId = $_POST['attribute_option_id'] ?? $_POST['color_id'] ?? null;

        if (!$skuId || !$colorId) {
            $response = ['success' => false, 'message' => 'Thiếu dữ liệu sản phẩm hoặc màu sắc.'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            } else {
                $_SESSION['error_message'] = $response['message'];
                header('Location: /cart');
                exit;
            }
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = $_COOKIE['session_id'] ?? session_id();

        $result = $this->cartService->updateProductColorByAttributeId(
            (int)$skuId, 
            (int)$colorId, 
            $userId, 
            $sessionId
        );

        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header('Location: /cart');
            exit;
        }
    }

    public function clearCart()
    {
        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = $_COOKIE['session_id'] ?? session_id();

        $result = $this->cartService->clearCart($userId, $sessionId);

        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header('Location: /cart');
            exit;
        }
    }

    public function getCartCount()
    {
        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = $_COOKIE['session_id'] ?? session_id();

        $count = $this->cartService->getCartItemCount($userId, $sessionId);
        
        echo json_encode(['count' => $count]);
    }

    public function confirmOrder()
    {
        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = $_COOKIE['session_id'] ?? session_id();

        // Lấy danh sách sản phẩm được chọn từ giỏ hàng
        $selectedProducts = $this->cartService->getSelectedCartItems($userId, $sessionId);

        if (empty($selectedProducts)) {
            $response = ['success' => false, 'message' => 'Không có sản phẩm nào được chọn.'];
            
            if ($this->isAjaxRequest()) {
                echo json_encode($response);
                return;
            } else {
                $_SESSION['error_message'] = $response['message'];
                header('Location: /cart');
                exit;
            }
        }

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($selectedProducts as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Lưu thông tin đơn hàng tạm vào SESSION
        $_SESSION['checkout'] = [
            'products' => $selectedProducts,
            'total_price' => $totalPrice,
            'created_at' => time()
        ];

        if ($this->isAjaxRequest()) {
            echo json_encode([
                'success' => true, 
                'message' => 'Đã chuẩn bị đơn hàng.', 
                'redirect' => '/checkout'
            ]);
        } else {
            header('Location: /checkout');
            exit;
        }
    }

    // =============================================================================
    // USER LOGIN CART MERGE
    // =============================================================================

    public function mergeSessionCart()
    {
        // Gọi khi user vừa login để merge session cart vào user cart
        $sessionId = session_id();
        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;

        if ($userId && $sessionId) {
            $result = $this->cartService->mergeSessionCartToUserCart($sessionId, $userId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Đã đồng bộ giỏ hàng thành công.';
            }
        }

        header('Location: /cart');
        exit;
    }

    // =============================================================================
    // HELPER METHODS
    // =============================================================================

    private function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    private function handleResponse(array $result, string $redirectUrl = '/cart')
    {
        if ($this->isAjaxRequest()) {
            echo json_encode($result);
        } else {
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
            header("Location: $redirectUrl");
            exit;
        }
    }

    // =============================================================================
    // API METHODS (for frontend AJAX calls)
    // =============================================================================

    public function api()
    {
        // Handle different API actions via query parameter
        $action = $_GET['action'] ?? $_POST['action'] ?? null;
        
        switch ($action) {
            case 'add':
                return $this->addToCart();
            case 'remove':
                return $this->delete();
            case 'update_quantity':
                return $this->updateProductQuantity();
            case 'update_selection':
                return $this->updateSelection();
            case 'select_all':
                return $this->toggleSelectAll();
            case 'update_color':
                return $this->updateColor();
            case 'clear':
                return $this->clearCart();
            case 'count':
                return $this->getCartCount();
            case 'get_cart':
                return $this->getCartData();
            default:
                echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    }

    private function getCartData()
    {
        $userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $sessionId = session_id();
        
        $cart = $this->cartService->getCart($userId, $sessionId);
        echo json_encode($cart);
    }
    public function checkout()
{
    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    // Lấy các sản phẩm đã chọn từ giỏ hàng
    $selectedItems = $this->cartService->getSelectedCartItems($userId, $sessionId);

    if (empty($selectedItems)) {
        $_SESSION['error_message'] = "Vui lòng chọn ít nhất 1 sản phẩm để đặt hàng.";
        header("Location: /cart");
        exit;
    }

    // Tính tổng tiền
    $total = 0;
    foreach ($selectedItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Chuyển tới trang checkout (có thể lưu vào session trước)
    $_SESSION['checkout_items'] = $selectedItems;
    $_SESSION['checkout_total'] = $total;

    header("Location: /checkout");
    exit;
}

}
