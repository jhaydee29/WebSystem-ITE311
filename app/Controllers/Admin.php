<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function __construct()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin access only.');
        }
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ];
        
        return view('admin/dashboard', $data);
    }
}
