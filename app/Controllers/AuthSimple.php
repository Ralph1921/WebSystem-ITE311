<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthSimple extends BaseController
{
    public function login()
    {
        $data = [];
        
        if ($this->request->getMethod() == 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            // Simple hardcoded login - NO DATABASE REQUIRED
            if ($email === 'terrado@gmail.com' && $password === 'siopao123') {
                // Create session
                $sessionData = [
                    'user_id' => 1,
                    'name' => 'Terrado User',
                    'email' => 'terrado@gmail.com',
                    'role' => 'admin',
                    'logged_in' => true
                ];
                
                session()->set($sessionData);
                session()->setFlashdata('success', 'Welcome back, Terrado User!');
                return redirect()->to('/dashboard');
            } else {
                $data['error'] = 'Invalid email or password';
            }
        }
        
        return view('auth/login_simple', $data);
    }
    
    public function dashboard()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to access the dashboard');
            return redirect()->to('/login-simple');
        }

        $data = [
            'user' => [
                'id' => session()->get('user_id'),
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        return view('auth/dashboard_simple', $data);
    }
    
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully');
        return redirect()->to('/login-simple');
    }
}