<?php

namespace App\Controllers\Admin;

use App\Models\admin\DashboardModel;
use App\Models\admin\HeaderModel;
use Core\View;
use Container;

class DashboardController
{
    private DashboardModel $model;
    private HeaderModel $headerModel;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new DashboardModel($pdo);
        $this->headerModel = new HeaderModel($pdo);
    }

    public function index()
    {
        $data = $this->model->getDashboardData();
        View::render('dashboard', $data);
    }
}
