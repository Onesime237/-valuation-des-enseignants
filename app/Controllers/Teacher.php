<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Teacher extends Controller
{
    public function login()
    {
        return view('teacher/login');
    }
}