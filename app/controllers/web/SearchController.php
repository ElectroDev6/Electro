<?php

namespace App\Controllers\Web;

use App\Services\SearchService;

class SearchController
{
    private $productService;

    public function __construct()
    {
        $this->productService = new SearchService();
    }

    public function suggestions()
    {
        $keyword = $_GET['q'] ?? '';
        header('Content-Type: application/json');

        if (strlen($keyword) < 2) {
            echo json_encode([]);
            return;
        }

        $results = $this->productService->searchProducts($keyword);
        echo json_encode($results);
    }
}
