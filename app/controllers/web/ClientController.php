<?php

namespace App\Controllers\Web;

use Core\View;

class ClientController
{
    public function Client()
    {
        View::render('client');
    }
}
