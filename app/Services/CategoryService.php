<?php

namespace App\Services;

use App\Models\CategoryModel;

class CategoryService
{
    private $categoryModel;

    public function __construct(\PDO $pdo)
    {
        $this->categoryModel = new CategoryModel($pdo);
    }

    public function getAllCategories()
    {
        return $this->categoryModel->getAllCategories();
    }
}
