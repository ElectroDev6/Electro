<?php

namespace App\controllers\web;

use Core\View;

class ProfileController
{
    public function showProfile()
    {
        View::render('profile');
    }
}
