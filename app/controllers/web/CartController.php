<?php
<<<<<<< HEAD
 namespace App\Controllers\Web;

 class CartController
 {
     public function index()
     {
         render('cart');
     }
 }
=======

namespace App\Controllers\Web;

use Core\View;

class CartController
{
    public function index()
    {
        View::render('cart');
    }
}
>>>>>>> 74037b24560cfd2c5f67a8cb0ba734508665f0c6
