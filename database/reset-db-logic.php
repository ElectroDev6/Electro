<?php

try {
    // Tắt ràng buộc khóa ngoại
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Truy vấn danh sách tất cả các bảng trong DB hiện tại
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
    }

    // Bật lại ràng buộc khóa ngoại
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Chạy lại schema và import
    require_once BASE_PATH . '/database/run-schema-logic.php';
    require_once BASE_PATH . '/database/run-import-logic.php';

    echo "✅ Reset toàn bộ DB thành công!";
} catch (PDOException $e) {
    echo "❌ Lỗi reset DB: " . $e->getMessage();
}
