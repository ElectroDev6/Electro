<?php

namespace App\Controllers\Web;

use Core\View;

class PrimaryPolicyController
{
    public function showPrivacyPolicy()
    {
        View::render('privacy-policy');
    }
}
