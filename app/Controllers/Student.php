<?php

namespace App\Controllers;

class Student extends BaseController
{
    public function dashboard(): string
    {
        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
        ];

        return view('student/dashboard', $data);
    }
}