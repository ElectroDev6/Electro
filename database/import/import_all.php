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
        // $cols = 'id, name';
        $placeholders = ':' . implode(', :', $columns);
        // $placeholders = ':id, :name';
        $sql = "INSERT INTO $table ($cols) VALUES ($placeholders)";
        // INSERT INTO categories (id, name) VALUES (:id, :name)
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

// 🟢 Gọi import các bảng tại đây
importJson('categories', ['category_id', 'type', 'product_total'], 'categories.json');

importJson('users', ['user_id', 'username', 'email', 'password', 'phone', 'role', 'status'], 'users.json');

importJson('blogs', ['blog_id', 'user_id', 'status'], 'blogs.json');

importJson('blog_contents', ['blog_content_id', 'blog_id', 'content_text', 'content_order'], 'blog_contents.json');

importJson('blog_images', ['blog_image_id', 'blog_id', 'image_url', 'alt_text', 'image_order'], 'blog_images.json');

importJson('brands', ['brand_id', 'name', 'description', 'logo_url'], 'brands.json');

importJson('carts', ['cart_id', 'user_id'], 'carts.json');

importJson('cart_items', ['cart_item_id', 'cart_id', 'quantity', 'unit_price'], 'cart_items.json');

importJson('categories_description', ['category_description_id', 'title', 'display_order'], 'categories_description.json');


importJson('category_description_content', ['category_description_content_id', 'category_description_id', 'text', 'content_order'], 'category_description_content.json');

importJson('category_description_images', ['category_description_image_id', 'category_description_id', 'image_url', 'alt_text', 'image_order'], 'category_description_images.json');

importJson('colors', ['color_id', 'name', 'hex_code', 'is_active'], 'colors.json');

importJson('products', ['product_id', 'brand_id', 'category_id', 'name'], 'products.json');


importJson('comments', ['comment_id', 'product_id', 'user_id', 'comment_content', 'like_count'], 'comments.json');

importJson('comment_replies', ['reply_id', 'comment_id', 'user_id', 'reply_content', 'like_count'], 'comment_replies.json');

importJson('coupons', ['coupon_id', 'code', 'name', 'description', 'discount_type', 'discount_value', 'min_order_value', 'usage_limit', 'used_count', 'start_date', 'end_date', 'is_active'], 'coupons.json');

importJson('user_addresses', ['address_id', 'user_id', 'address_line', 'province', 'district', 'ward'], 'user_addresses.json');

importJson('orders', ['order_id', 'user_id', 'order_number', 'status', 'subtotal', 'discount_amount', 'shipping_fee', 'total_amount', 'address_id', 'payment_method'], 'orders.json');


importJson('storage_options', ['storage_id', 'capacity', 'is_active'], 'storage_options.json');

importJson('product_variants', ['variant_id', 'product_id', 'color_id', 'storage_id', 'original_price', 'discount_percentage', 'stock_quantity', 'is_available'], 'product_variants.json');


importJson('order_items', ['order_item_id', 'order_id', 'variant_id', 'quantity', 'unit_price', 'discount_amount', 'total_price'], 'order_items.json');

importJson('payment_methods', ['payment_id', 'method_name', 'provider', 'is_active', 'installment_options', 'interest_rate', 'minimum_amount'], 'payment_methods.json');


importJson('product_descriptions', ['product_description_id', 'product_id', 'title', 'display_order'], 'product_descriptions.json');

importJson('product_description_content', ['product_description_content_id', 'product_description_id', 'content_text', 'content_order'], 'product_description_content.json');

importJson('product_description_images', ['description_images_id', 'product_description_id', 'image_url', 'alt_text', 'image_order'], 'product_description_images.json');


importJson('product_media', ['media_id', 'product_id', 'media_type', 'url', 'alt_text', 'display_order'], 'product_media.json');

importJson('product_questions', ['question_id', 'product_id', 'user_id', 'question_title', 'question_content', 'answer_content', 'question_date', 'answer_date'], 'product_questions.json');

importJson('product_specifications', ['spec_id', 'product_id', 'spec_group', 'spec_name', 'spec_value', 'display_order'], 'product_specifications.json');

importJson('product_promotions', ['promotion_id', 'product_id', 'name', 'description', 'promotion_type', 'discount_value', 'start_date', 'end_date', 'is_active', 'terms_conditions'], 'promotions.json');


importJson('reviews', ['review_id', 'product_id', 'user_id', 'rating', 'title', 'review_content', 'status', 'is_verified_purchase', 'helpful_count'], 'reviews.json');


importJson('review_images', ['review_image_id', 'review_id', 'image_url', 'alt_text', 'display_order'], 'review_images.json');

importJson('warranty', ['warranty_id', 'product_id', 'name', 'description', 'original_price', 'current_price', 'duration_months', 'coverage'], 'warranty.json');
