<?php

namespace App\Controllers\Web;

use Core\View;

class RefundController
{
    public function showRefundPolicy()
    {
        View::render('refund');
    }
}
