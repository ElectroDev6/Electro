<?php

namespace App\Controllers\Web;

use App\Services\SearchService;

class SearchController
{
    private $service;

    public function __construct(\PDO $pdo)
    {
        $this->service = new SearchService($pdo);
    }

    public function suggestions()
    {
        $q = $_GET['q'] ?? '';
        header('Content-Type: application/json');
        if (mb_strlen(trim($q)) < 2) {
            echo json_encode([]);
            return;
        }

        echo json_encode($this->service->suggestions($q));
    }
}
