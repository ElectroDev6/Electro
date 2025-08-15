<?php

namespace App\Services;

use App\Models\SearchModel;

class SearchService
{
    public function searchProducts(string $keyword): array
    {
        $productModel = new SearchModel();
        return $productModel->searchByName($keyword);
    }
}
