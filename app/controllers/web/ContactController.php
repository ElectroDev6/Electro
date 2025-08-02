<?php

namespace App\Controllers\Web;
use Core\View;
class ContactController
{
    public function contact()
    {
        View::render('contact');
    }
}
