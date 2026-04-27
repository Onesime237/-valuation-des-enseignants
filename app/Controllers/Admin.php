<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        
        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
        ];

        return view('admin/dashboard', $data);
    }
}