<?php

namespace App\Controllers\Web;



use Core\View;

class ThankyouController
{
    public function showConfirmation()
    {
        View::render('thankyou');
    }
}
