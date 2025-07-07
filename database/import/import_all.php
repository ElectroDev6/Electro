<?php
require_once BASE_PATH . '/bootstrap.php';
$pdo = Container::get('pdo');

function importJson($table, $columns, $jsonFile)
{
    global $pdo;

    $path = BASE_PATH . "/database/seed/$jsonFile";
    if (!file_exists($path)) {
        echo "❌ Không tìm thấy file: $jsonFile\n";
        return;
    }

    $data = json_decode(file_get_contents($path), true);
    // Sẽ chuyển chuỗi đó thành mảng PHP.
    if (!is_array($data)) {
        echo "❌ Dữ liệu không hợp lệ trong $jsonFile\n";
        return;
    }

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

    echo "✅ Đã nhập dữ liệu bảng `$table` từ file `$jsonFile`\n";
}

// 🟢 Gọi import các bảng tại đây
importJson('categories', ['id', 'name'], 'categories.json');
importJson('brands', ['id', 'name'], 'brands.json');
// Thêm dòng import khác nếu cần
