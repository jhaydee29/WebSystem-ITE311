<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Teacher extends BaseController
{
    public function __construct()
    {
        // Constructor - session check will be done in individual methods
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Teacher Dashboard',
            'user' => [
                'name' => session()->get('name') ?? 'Teacher',
                'role' => session()->get('role') ?? 'teacher'
            ]
        ];
        
        return view('teacher_dashboard', $data);
    }

    public function courses()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        return view('teacher_dashboard', ['title' => 'My Courses']);
    }

    public function gradebook()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        return view('teacher_dashboard', ['title' => 'Gradebook']);
    }

    public function assignments()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        return view('teacher_dashboard', ['title' => 'Assignments']);
    }

    public function students()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        return view('teacher_dashboard', ['title' => 'Students']);
    }
}
