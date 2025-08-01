<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getCartWithSummary(int $userId): array
    {
        $cartItems = Cart::getByUser($userId);

        $products = [];
        $total = 0;
        $discount = 0;
        $shipping = 20000;

        foreach ($cartItems as $item) {
            $product = Product::getById($item['productId']);
            if (!$product) continue;

            $lineTotal = $product['price_current'] * $item['quantity'];
            $lineDiscount = ($product['price_original'] - $product['price_current']) * $item['quantity'];

            $products[] = [
                'id' => $item['productId'],
                'name' => $product['name'],
                'image' => $product['image'],
                'color' => $product['color'],
                'price_current' => $product['price_current'],
                'price_original' => $product['price_original'],
                'quantity' => $item['quantity'],
                'selected' => $item['selected'] ?? true,
                'warranty' => [
                    'enabled' => $item['warranty_enabled'] ?? false,
                    'price' => 200,
                    'price_original' => 400,
                ],
            ];

            if ($item['selected'] ?? true) {
                $total += $lineTotal;
                $discount += $lineDiscount;

                if ($item['warranty_enabled'] ?? false) {
                    $total += 200;
                    $discount += 200;
                }
            }
        }

        return [
            'products' => $products,
            'summary' => [
                'total_price' => $total,
                'total_discount' => $discount,
                'shipping_fee' => $shipping,
                'final_total' => $total + $shipping - $discount,
            ]
        ];
    }

                public function addToCart(int $userId, int $productId, int $quantity = 1): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->addItem($productId, $quantity);
                    $cart->save();
                }

                public function updateQuantity(int $userId, int $productId, int $quantity): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->updateQuantity($productId, $quantity);
                    $cart->save();
                }

                public function removeFromCart(int $userId, int $productId): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->removeItem($productId);
                    $cart->save();
                }

                public function toggleSelect(int $userId, int $productId, bool $selected): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->updateSelect($productId, $selected);
                    $cart->save();
                }

                public function toggleWarranty(int $userId, int $productId, bool $enabled): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->updateWarranty($productId, $enabled);
                    $cart->save();
                }

                public function clearCart(int $userId): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->clearAll();
                    $cart->save();
                }

                public function selectAll(int $userId): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->selectAll(); // Giả định Cart model có hàm này
                    $cart->save();
                }

                public function unselectAll(int $userId): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->unselectAll(); // Giả định Cart model có hàm này
                    $cart->save();
                }
                public function updateColor(int $userId, int $productId, string $color): void
                {
                    $cart = Cart::getOrCreateByUser($userId);
                    $cart->updateColor($productId, $color);
                    $cart->save();
                    
                }
            }
