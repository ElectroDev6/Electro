<?php

namespace App\Services;

use App\Models\PromotionModel;
use App\Services\ProductService;
use DateTime;
use DateTimeZone;

class PromotionService
{
    private $productService;
    private $promotionModel;
    private $timezone;

    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
        $this->promotionModel = new PromotionModel($pdo);
        $this->timezone = new DateTimeZone('+0700');
    }

    // Lấy dữ liệu cho container sale
    public function getSaleData(int $limit = 8)
    {
        $now = new DateTime('now', $this->timezone);
        $currentDateTime = $now->format('Y-m-d H:i:s');

        // Lấy sản phẩm sale hiện tại
        $saleProducts = $this->productService->getSaleProducts($limit);

        // Lấy các ngày sale tương lai (3 ngày tiếp theo)
        $tomorrow = (clone $now)->modify('+1 day')->format('Y-m-d');
        $endDate = (clone $now)->modify('+3 days')->format('Y-m-d');

        $futureSaleDates = $this->promotionModel->getFutureSaleDates($tomorrow . ' 00:00:00', $endDate . ' 23:59:59');

        // Lấy ngày và thời gian còn lại của sale hiện tại
        $currentSale = $saleProducts[0] ?? null;
        $timeRemaining = $currentSale ? $this->getTimeRemaining($this->promotionModel->getSaleEndDate($currentSale['product_id'])) : 'N/A';
        $currentSaleDate = $currentSale ? date('d/m', strtotime($this->promotionModel->getSaleStartDate($currentSale['product_id']))) : 'N/A';
        $endDate = $currentSale ? $this->promotionModel->getSaleEndDate($currentSale['product_id']) : null;

        return [
            'saleProducts' => $saleProducts,
            'futureSaleDates' => $futureSaleDates,
            'currentSaleDate' => $currentSaleDate,
            'timeRemaining' => $timeRemaining,
            'endDate' => $endDate
        ];
    }

    // Lấy danh sách sản phẩm sale theo ngày
    public function getSaleProductsByDate(string $selectedDate, int $limit = 8): array
    {
        return $this->productService->getProducts([
            'is_sale' => true,
            'date' => $selectedDate,
            'limit' => $limit
        ]);
    }

    // Tính thời gian còn lại
    private function getTimeRemaining(?string $endDate): string
    {
        if (!$endDate) {
            return 'N/A';
        }
        $now = new DateTime('now', $this->timezone);
        $end = new DateTime($endDate, $this->timezone);
        if ($now >= $end) {
            return 'Đã kết thúc';
        }
        $interval = $now->diff($end);
        return sprintf("%02d : %02d : %02d", $interval->h, $interval->i, $interval->s);
    }
}
