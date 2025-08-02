<?php

namespace App\Controllers\Admin\Products;
// namespace trong PHP dùng để định danh (xác định) vị trí và tên đầy đủ của class
use Core\View;
use Container;

class CreateProductController
{
    public function index()
    {
        View::render('products/create');
    }
}