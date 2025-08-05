<?php

namespace App\controllers\web;

use Core\View;

class InforController
{
    public function infor()
    {
        $user = [
            'name' => 'Nguyễn Khánh Duy',
            'phone' => '0912812321',
            'email' => 'hetoce*****@gmail.com',
            'dob' => ['day' => '01', 'month' => '01', 'year' => '2000'],
            'gender' => 'Nam',
            'address' => [
                'city' => 'TP Hồ Chí Minh',
                'district' => 'Huyện Củ Chi',
                'ward' => 'Xã Tân Phú Trung',
                'street' => 'Số 2.4, ABC'
            ],
            'avatar' => 'https://i.pinimg.com/1200x/57/bb/f5/57bbf563a06ca4704171f1bbd0bd52b3.jpg'
        ];

        View::render('infor', ['user' => $user]);
    }
    
}