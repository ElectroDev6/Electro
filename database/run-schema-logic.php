<?php
$pdo = Container::get('pdo');
$sql = file_get_contents(BASE_PATH . '/database/schema.sql');

try {
    $pdo->exec($sql);
    echo "✅ Đã tạo bảng thành công từ schema.sql\n";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
