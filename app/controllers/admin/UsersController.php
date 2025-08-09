<?php
namespace App\Controllers\Admin;
use App\Controllers\Admin\Users\CreateUserController;
use App\Controllers\Admin\Users\UpdateUserController;
use App\Controllers\Admin\Users\DeleteUserController;
use App\Controllers\Admin\Users\ReadUserController;

class UsersController
{
    public function index()
    {
        $controller = new ReadUserController();
        $controller->list(); 
    }

    public function create()
    {
        $controller = new CreateUserController();
        $controller->index();
    }

    public function handleCreate()
    {
        $controller = new CreateUserController();
        $controller->handleCreate();
    }

    public function detail()
    {
        $controller = new ReadUserController();
        $controller->detail();
    }

    public function update()
    {
        $controller = new UpdateUserController();
        $controller->index();
    }

    public function handleUpdate()
    {
        $controller = new UpdateUserController();
        $controller->handle();
    }

    public function delete()
    {
        DeleteUserController::handle();
    }
}

?>