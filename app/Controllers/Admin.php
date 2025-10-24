<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function __construct()
    {
<<<<<<< HEAD
        // Constructor - session check will be done in individual methods
=======
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
>>>>>>> origin/recovered-master
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'user' => [
<<<<<<< HEAD
                'name' => session()->get('name') ?? 'Admin',
                'role' => session()->get('role') ?? 'admin'
            ]
        ];
        
        return view('admin_dashboard', $data);
    }

    public function users()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        return view('admin_dashboard', ['title' => 'Manage Users']);
    }

    public function courses()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        return view('admin_dashboard', ['title' => 'Manage Courses']);
    }

    public function reports()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        return view('admin_dashboard', ['title' => 'Reports']);
    }

    public function settings()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
        
        return view('admin_dashboard', ['title' => 'Settings']);
=======
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ];
        
        return view('admin/dashboard', $data);
>>>>>>> origin/recovered-master
    }
}
