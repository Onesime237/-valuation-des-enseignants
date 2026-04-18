<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function login()
    {
        return view('admin/login');
    }
}