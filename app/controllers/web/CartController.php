<?php
namespace App\Controllers\Web;
use Core\View;
class CartController
{
    public function index()
    {
      View::render('cart'); // Gọi view cart.php
    }
}

?>