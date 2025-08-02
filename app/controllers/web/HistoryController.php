<?php

namespace App\controllers\web;

use Core\View;

class HistoryController
{
    public function history()
    {
        View::render('history');
    }
}