<?php

namespace App\Controllers\Web;

use Core\View;

class ClientController
{
    public function showClients()
    {
        View::render('policy-client');
    }
}
