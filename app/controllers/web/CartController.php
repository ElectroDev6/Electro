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
        $sessionId = session_id();

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
        } else {
            $_SESSION['success_message'] = $message;
            header('Location: /cart');
            exit;
        }
    }
    public function toggleSelectItem()
    {
        $skuId = $_POST['sku_id'] ?? null;
        $selected = $_POST['selected'] ?? false;

        if (!$skuId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing sku_id']);
            return;
        }

        if (!isset($_SESSION['selected_cart_items'])) {
            $_SESSION['selected_cart_items'] = [];
        }

        if ($selected) {
            // Thêm vào danh sách
            if (!in_array($skuId, $_SESSION['selected_cart_items'])) {
                $_SESSION['selected_cart_items'][] = $skuId;
            }
        } else {
            // Bỏ khỏi danh sách
            $_SESSION['selected_cart_items'] = array_diff(
                $_SESSION['selected_cart_items'],
                [$skuId]
            );
        }

        echo json_encode(['success' => true]);
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
    public function updateSelectedItems()
    {
        if (isset($_POST['selected_skus']) && is_array($_POST['selected_skus'])) {
            $_SESSION['selected_cart_items'] = $_POST['selected_skus'];
        } else {
            $_SESSION['selected_cart_items'] = [];
        }
        echo json_encode(['status' => 'success']);
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

    public function confirmOrder(Request $request)
    {
        $userId = $request->user()->id; // Lấy ID người dùng từ session
        $cart = Cart::where('user_id', $userId)->first(); // Lấy giỏ hàng của người dùng

        if (!$cart) {
            return response()->json(['message' => 'Giỏ hàng trống'], 400);
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = 0;
        $cartItems = CartItem::where('cart_id', $cart->cart_id)->get();
        foreach ($cartItems as $item) {
            $totalPrice += $item->quantity * $item->sku->price; // Giả sử bạn có phương thức sku để lấy giá
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $userId,
            'user_address_id' => $request->input('user_address_id'), // Lấy địa chỉ từ request
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Thêm các mục vào đơn hàng
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'sku_id' => $item->sku_id,
                'quantity' => $item->quantity,
                'price' => $item->sku->price,
            ]);
        }

        // Xóa giỏ hàng
        CartItem::where('cart_id', $cart->cart_id)->delete();
        $cart->delete();

        return response()->json(['message' => 'Đơn hàng đã được xác nhận', 'order_id' => $order->order_id], 201);
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

        header('Location: /checkout');
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
    public function placeOrder($userId, $userAddressId, $couponId = null)
    {
        $cartId = $this->cartService->cartModel->getOrCreateCart($userId, null);
        if (!$cartId) {
            return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
        }

        $items = $this->cartService->cartModel->getCartItemsWithDetails($cartId);
        if (empty($items)) {
            return ['success' => false, 'message' => 'Giỏ hàng trống.'];
        }

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // TODO: Xử lý coupon giảm giá nếu có
        $discount = 0;
        $finalPrice = $totalPrice - $discount;

        try {
            $pdo = $this->cartService->cartModel->getPDO(); // Nếu bạn có method lấy PDO
            $pdo->beginTransaction();

            // Thêm orders
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, user_address_id, coupon_id, status, total_price) VALUES (?, ?, ?, 'pending', ?)");
            $stmt->execute([$userId, $userAddressId, $couponId, $finalPrice]);
            $orderId = $pdo->lastInsertId();

            // Thêm order_items
            $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, sku_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmtItem->execute([$orderId, $item['sku_id'], $item['quantity'], $item['price']]);
            }

            // Xóa cart_items và cart
            $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
            $stmt->execute([$cartId]);
            $stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id = ?");
            $stmt->execute([$cartId]);

            $pdo->commit();

            return ['success' => true, 'message' => 'Đơn hàng đã được tạo.', 'order_id' => $orderId];
        } catch (\PDOException $e) {
            $pdo->rollBack();
            error_log("Place order failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Đã có lỗi khi tạo đơn hàng.'];
        }
    }
}
