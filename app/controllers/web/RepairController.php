<?php

namespace App\Controllers\Web;

use Core\View;

class RepairController
{
    public function showRepair()
    {
        View::render('repair');
    }
}
