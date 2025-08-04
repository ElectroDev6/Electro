<?php
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/Core/Container.php';

$pdo = \Container::get('pdo');

echo "\n📦 DATABASE TOOL\n";
echo "-------------------\n";
echo "1. Reset toàn bộ DB (drop & create lại)\n";
echo "2. Import schema (tạo bảng từ file .sql)\n";
echo "3. Import seed data (JSON -> DB)\n";
echo "Chọn chức năng (1/2/3): ";

$choice = trim(fgets(STDIN));

switch ($choice) {
    case '1':
        require BASE_PATH . '/database/reset-db-logic.php';
        break;
    case '2':
        require BASE_PATH . '/database/run-schema-logic.php';
        break;
    case '3':
        require BASE_PATH . '/database/run-import-logic.php';
        break;
    default:
        echo "❌ Lựa chọn không hợp lệ. Hãy chọn 1, 2 hoặc 3.\n";
        break;
}