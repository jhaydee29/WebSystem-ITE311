<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Teacher extends BaseController
{
    public function __construct()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Teacher Dashboard',
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ];
        
        return view('teacher/dashboard', $data);
    }
}
