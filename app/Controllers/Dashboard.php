<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        // Simulate logged in user data
        $data = [
            'user' => [
                'id' => 1,
                'name' => 'Terrado User',
                'email' => 'terrado@gmail.com',
                'role' => 'admin'
            ]
        ];

        // Set success flash message
        session()->setFlashdata('success', 'Welcome back, Terrado User!');
        
        return view('dashboard_view', $data);
    }
}