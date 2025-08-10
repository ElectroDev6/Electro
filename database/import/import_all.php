<?php

require_once BASE_PATH . '/Core/Container.php';

function importJson($table, $columns, $jsonFile, &$skuCodeMap = [])
{
    $pdo = \Container::get('pdo');

    $path = BASE_PATH . "/database/seed/$jsonFile";
    if (!file_exists($path)) {
        echo "❌ Không tìm thấy file: $jsonFile\n";
        return $skuCodeMap;
    }

    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) {
        echo "❌ Dữ liệu không hợp lệ trong $jsonFile\n";
        return $skuCodeMap;
    }

    try {
        $pdo->beginTransaction();

        $cols = implode(', ', $columns);
        $placeholders = ':' . implode(', :', $columns);
        $sql = "INSERT INTO $table ($cols) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);

        $newSkuCodeMap = $skuCodeMap;
        $insertedCount = 0;
        $recordsToRetry = [];

        // Xử lý riêng cho các bảng phân cấp
        $isNested = in_array($table, ['skus', 'attribute_option_sku', 'variant_images']);
        foreach ($data as $item) {
            $records = $isNested ? ($item[$table === 'skus' ? 'skus' : ($table === 'attribute_option_sku' ? 'attribute_options' : 'images')] ?? []) : [$item];
            foreach ($records as $row) {
                $values = [];
                foreach ($columns as $col) {
                    if ($col === 'sku_id' && isset($row['sku_code'])) {
                        $values[":$col"] = isset($newSkuCodeMap[$row['sku_code']]) ? $newSkuCodeMap[$row['sku_code']] : null;
                    } elseif ($col === 'product_id' && !isset($row['product_id']) && isset($item['product_id'])) {
                        $values[":$col"] = $item['product_id'];
                    } else {
                        $values[":$col"] = $row[$col] ?? null;
                    }
                }
                try {
                    $stmt->execute($values);
                    $insertedCount++;
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000 && in_array($table, ['attribute_option_sku', 'variant_images', 'promotions', 'cart_items', 'order_items'])) {
                        $recordsToRetry[] = ['row' => $row, 'values' => $values];
                    } else {
                        throw $e;
                    }
                }

                // Cập nhật sku_id vào ánh xạ sau khi insert skus
                if ($table === 'skus' && isset($row['sku_code'])) {
                    $skuId = $pdo->lastInsertId();
                    $newSkuCodeMap[$row['sku_code']] = $skuId;
                    if (!isset($skuCodeMap[$row['sku_code']])) {
                        $updateSql = "UPDATE $table SET sku_id = :sku_id WHERE sku_id IS NULL AND sku_code = :sku_code";
                        $updateStmt = $pdo->prepare($updateSql);
                        $updateStmt->execute([':sku_id' => $skuId, ':sku_code' => $row['sku_code']]);
                    }
                }
            }
        }

        // Thử lại các bản ghi có sku_id null sau khi cập nhật ánh xạ
        if (!empty($recordsToRetry) && $newSkuCodeMap !== $skuCodeMap) {
            foreach ($recordsToRetry as $retry) {
                $row = $retry['row'];
                $values = $retry['values'];
                if (isset($row['sku_code']) && isset($newSkuCodeMap[$row['sku_code']])) {
                    $values[':sku_id'] = $newSkuCodeMap[$row['sku_code']];
                    $stmt->execute($values);
                    $insertedCount++;
                }
            }
        }

        $pdo->commit();
        echo "✅ Đã nhập dữ liệu bảng `$table` từ file `$jsonFile`\n";
        return $newSkuCodeMap;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "❌ Lỗi khi nhập `$jsonFile`: " . $e->getMessage() . "\n";
        return $skuCodeMap;
    }
}

// Khởi tạo ánh xạ sku_code -> sku_id
$skuCodeMap = [];

// Nhập các bảng không phụ thuộc
importJson('categories', ['name', 'image', 'description', 'slug'], 'categories.json');
importJson('subcategories', ['subcategory_id', 'category_id', 'name', 'subcategory_slug'], 'subcategories.json');
importJson('brands', ['name', 'description', 'logo_url'], 'brands.json');
importJson('products', ['name', 'brand_id', 'subcategory_id', 'base_price', 'slug', 'is_featured'], 'products.json');
importJson('product_contents', ['product_id', 'description', 'image_url'], 'product_contents.json');
importJson('product_specs', ['product_id', 'spec_name', 'spec_value', 'display_order'], 'product_specs.json');
importJson('attributes', ['name', 'display_type'], 'attributes.json');
importJson('attribute_options', ['attribute_option_id', 'attribute_id', 'value', 'display_order'], 'attribute_options.json');

// Nhập skus và lấy ánh xạ
$skuCodeMap = importJson('skus', ['sku_code', 'product_id', 'price', 'stock_quantity', 'is_active'], 'skus.json', $skuCodeMap);

// Nhập các bảng phụ thuộc
$skuCodeMap = importJson('attribute_option_sku', ['sku_id', 'attribute_option_id'], 'attribute_option_sku.json', $skuCodeMap);
$skuCodeMap = importJson('variant_images', ['sku_id', 'image_set', 'is_default', 'sort_order'], 'variant_images.json', $skuCodeMap);
$skuCodeMap = importJson('promotions', ['sku_code', 'discount_percent', 'start_date', 'end_date'], 'promotions.json', $skuCodeMap);

// Nhập các bảng còn lại
importJson('users', ['name', 'email', 'password_hash', 'phone_number', 'gender', 'birth_date', 'role', 'is_active', 'avatar_url'], 'users.json');
importJson('user_address', ['user_id', 'address_line1', 'ward_commune', 'district', 'province_city', 'is_default'], 'user_address.json');
importJson('cart', ['user_id', 'session_id'], 'cart.json');
importJson('cart_items', ['cart_id', 'sku_id', 'quantity', 'selected', 'color', 'warranty_enabled', 'voucher_code'], 'cart_items.json');
importJson('reviews', ['user_id', 'product_id', 'parent_review_id', 'rating', 'comment_text', 'status'], 'reviews.json');
importJson('wishlist', ['user_id', 'product_id', 'added_at'], 'wishlist.json');
importJson('coupons', ['code', 'discount_percent', 'start_date', 'expires_at', 'max_usage', 'is_active'], 'coupons.json');
importJson('orders', ['user_id', 'user_address_id', 'coupon_id', 'status', 'total_price'], 'orders.json');
importJson('order_items', ['order_id', 'sku_id', 'quantity', 'price'], 'order_items.json');
importJson('payments', ['order_id', 'payment_method', 'amount', 'payment_date', 'status'], 'payments.json');
importJson('shipping', ['order_id', 'carrier', 'tracking_number', 'estimated_delivery', 'status'], 'shipping.json');
