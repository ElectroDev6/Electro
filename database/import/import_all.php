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
importJson('brands', ['brand_id', 'name'], 'brands.json');
importJson('categories', ['category_id', 'name'], 'categories.json');
importJson('products', ['product_id', 'brand_id', 'category_id', 'name'], 'products.json');
