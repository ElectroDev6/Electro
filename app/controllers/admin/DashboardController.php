<?php

namespace App\Controllers\Admin;

use App\Models\admin\DashboardModel;
use Core\View;
use Container;

class DashboardController
{
    private DashboardModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new DashboardModel($pdo);
    }

    public function index()
    {
        $data = $this->model->getDashboardData();
        View::render('dashboard', $data);
    }
}
