<?php

namespace App\Controllers;

class Teacher extends BaseController
{
    public function dashboard(): string
    {
        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
        ];

        return view('teacher/dashboard', $data);
    }
}