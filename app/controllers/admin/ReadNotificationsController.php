<?php
namespace App\Controllers\Admin;

use App\Models\admin\HeaderModel;
use Container;
use Core\View;

class ReadNotificationsController
{
    private HeaderModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new HeaderModel($pdo);
    }

   
}