<?php

namespace App\controllers\web;

use Core\View;

class HistoryController
{
    public function showHistory()
    {
        View::render('history');
    }
}
