<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function __construct()
    {
        // Constructor - session check will be done in individual methods
    }

    public function dashboard()
    {
        $this->data['title'] = 'Admin Dashboard';
        $this->data['user'] = [
            'name' => session()->get('name') ?? 'Admin',
            'role' => session()->get('role') ?? 'admin'
        ];
        
        return view('admin_dashboard', $this->data);
    }

    public function users()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        $this->data['title'] = 'Manage Users';
        return view('admin_dashboard', $this->data);
    }

    public function courses()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        $this->data['title'] = 'Manage Courses';
        return view('admin_dashboard', $this->data);
    }

    public function reports()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        $this->data['title'] = 'Reports';
        return view('admin_dashboard', $this->data);
    }

    public function settings()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        $this->data['title'] = 'Settings';
        return view('admin_dashboard', $this->data);
    }
}
