<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\Products\CreateProductController;
use App\Controllers\Admin\Products\UpdateProductController;
use App\Controllers\Admin\Products\DeleteProductController;
use App\Controllers\Admin\Products\ReadProductController;

class ProductsController
{
    public function index()
    {
        $controller = new ReadProductController();
        $controller->list();
    }

    public function create()
    {
        $controller = new CreateProductController();
        $controller->index();
    }

    public function handleCreate()
    {
        $controller = new CreateProductController();
        $controller->handleCreate();
    }

    public function detail()
    {
        $controller = new ReadProductController();
        $controller->detail();
    }

    public function update()
    {
        $controller = new UpdateProductController();
        $controller->index();
    }

    public function handle()
    {
        $controller = new UpdateProductController();
        $controller->handle();
    }

    public function delete()
    {
        $controller = new DeleteProductController();
        $controller->handle();
    }
}