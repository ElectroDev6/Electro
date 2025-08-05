<?php

function importJson($table, $columns, $jsonFile)
{
    global $pdo;

    $path = BASE_PATH . "/database/seed/$jsonFile";
    if (!file_exists($path)) {
        echo "❌ Không tìm thấy file: $jsonFile\n";
        return;
    }

    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) {
        echo "❌ Dữ liệu không hợp lệ trong $jsonFile\n";
        return;
    }

    try {
        $pdo->beginTransaction(); // ✅ Bắt đầu transaction

        $cols = implode(', ', $columns);
        $placeholders = ':' . implode(', :', $columns);
        $sql = "INSERT INTO $table ($cols) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);

        foreach ($data as $row) {
            $values = [];
            foreach ($columns as $col) {
                $values[":$col"] = $row[$col] ?? null;
            }
            $stmt->execute($values);
        }

        $pdo->commit(); // ✅ Commit nếu không lỗi
        echo "✅ Đã nhập dữ liệu bảng `$table` từ file `$jsonFile`\n";
    } catch (PDOException $e) {
        $pdo->rollBack(); // ⛔ Rollback nếu có lỗi
        echo "❌ Lỗi khi nhập `$jsonFile`: " . $e->getMessage() . "\n";
    }
}




importJson('categories', ['category_id', 'name', 'image', 'description', 'slug'], 'categories.json');

importJson('subcategories', ['subcategory_id', 'category_id', 'name'], 'subcategories.json');

importJson('brands', ['brand_id', 'name', 'description', 'logo_url'], 'brands.json');

importJson('products', ['product_id', 'name', 'brand_id', 'subcategory_id', 'description', 'base_price', 'slug', 'is_featured'], 'products.json');

importJson('product_descriptions', ['product_description_id', 'product_id', 'section_title', 'content_text', 'image_url', 'sort_order'], 'product_descriptions.json');

importJson('attributes', ['attribute_id', 'name', 'display_type'], 'attributes.json');

importJson('attribute_options', ['attribute_option_id', 'attribute_id', 'value', 'display_order'], 'attribute_options.json');

importJson('skus', ['sku_id', 'product_id', 'sku_code', 'price', 'stock_quantity', 'is_active'], 'skus.json');

importJson('attribute_option_sku', ['sku_id', 'attribute_option_id'], 'attribute_option_sku.json');

importJson('variant_images', ['image_id', 'sku_id', 'default_url', 'thumbnail_url', 'gallery_url', 'is_default', 'sort_order'], 'variant_images.json');

importJson('promotions', ['promotion_id', 'sku_id', 'discount_percent', 'start_date', 'end_date'], 'promotions.json');

importJson('users', ['user_id', 'name', 'email', 'password_hash', 'phone_number', 'gender', 'birth_date', 'role', 'is_active', 'avatar_url'], 'users.json');

importJson('user_address', ['user_address_id', 'user_id', 'address_line1', 'ward_commune', 'district', 'province_city', 'is_default'], 'user_address.json');

importJson('cart', ['cart_id', 'user_id', 'session_id'], 'cart.json');

importJson('cart_items', ['cart_item_id', 'cart_id', 'sku_id', 'quantity'], 'cart_items.json');

importJson('reviews', ['review_id', 'user_id', 'product_id', 'parent_review_id', 'rating', 'comment_text', 'review_date'], 'reviews.json');

importJson('wishlist', ['user_id', 'product_id', 'added_at'], 'wishlist.json');

importJson('coupons', ['coupon_id', 'code', 'discount_percent', 'start_date', 'expires_at', 'max_usage', 'is_active'], 'coupons.json');

importJson('orders', ['order_id', 'user_id', 'user_address_id', 'coupon_id', 'status', 'total_price'], 'orders.json');

importJson('order_items', ['order_item_id', 'order_id', 'sku_id', 'quantity', 'price'], 'order_items.json');

importJson('payments', ['payment_id', 'order_id', 'payment_method', 'amount', 'payment_date', 'status'], 'payments.json');

importJson('shipping', ['shipping_id', 'order_id', 'carrier', 'tracking_number', 'estimated_delivery', 'status'], 'shipping.json');
