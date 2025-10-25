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
        $this->data['title'] = 'Teacher Dashboard';
        $this->data['user'] = [
            'name' => session()->get('name') ?? 'Teacher',
            'role' => session()->get('role') ?? 'teacher'
        ];
        
        return view('teacher_dashboard', $this->data);
    }

    public function courses()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        $this->data['title'] = 'My Courses';
        return view('teacher_dashboard', $this->data);
    }

    public function gradebook()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        $this->data['title'] = 'Gradebook';
        return view('teacher_dashboard', $this->data);
    }

    public function assignments()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        $this->data['title'] = 'Assignments';
        return view('teacher_dashboard', $this->data);
    }

    public function students()
    {
        // Check if user is logged in and is a teacher
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/login')->with('error', 'Access denied. Teacher access only.');
        }
        
        $this->data['title'] = 'Students';
        return view('teacher_dashboard', $this->data);
    }
}
