<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\Categories\CreateCategoryController;
use App\Controllers\Admin\Categories\UpdateCategoryController;
use App\Controllers\Admin\Categories\DeleteCategoryController;
use App\Controllers\Admin\Categories\ReadCategoryController;

class CategoriesController
{
    public function index()
    {
        $controller = new ReadCategoryController();
        $controller->list();
    }

    public function create()
    {
        $controller = new CreateCategoryController();
        $controller->index();
    }

    public function handleCreate()
    {
        $controller = new CreateCategoryController();
        $controller->handleCreate();
    }

    public function detail()
    {
        $controller = new ReadCategoryController();
        $controller->detail();
    }

    public function update()
    {
        $controller = new UpdateCategoryController();
        $controller->index();
    }

    public function handleUpdate()
    {
        $controller = new UpdateCategoryController();
        $controller->handle();
    }

    public function delete()
    {
        DeleteCategoryController::handle();
    }

    public function getSubcategories()
    {
        $controller = new ReadCategoryController();
        $controller->getSubcategories();
    }
}