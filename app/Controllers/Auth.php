<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $db;
    
    public function __construct()
    {
        // TEMPORARILY DISABLED DATABASE CONNECTION
        // $this->db = \Config\Database::connect();
    }

    public function register()
    {
        $data = [];
        
        if ($this->request->getMethod() == 'post') {
            // Set validation rules
            $rules = [
                'name' => [
                    'rules' => 'required|min_length[3]|max_length[50]',
                    'errors' => [
                        'required' => 'Name is required',
                        'min_length' => 'Name must be at least 3 characters',
                        'max_length' => 'Name cannot exceed 50 characters'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address',
                        'is_unique' => 'This email is already registered'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be at least 6 characters'
                    ]
                ],
                'password_confirm' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Password confirmation is required',
                        'matches' => 'Passwords do not match'
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                // Hash the password
                $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                
                // Prepare data for insertion
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => $hashedPassword,
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Insert user into database
                try {
                    $this->db->table('users')->insert($userData);
                    session()->setFlashdata('success', 'Registration successful! Please login.');
                    return redirect()->to('/login');
                } catch (\Exception $e) {
                    $data['error'] = 'Registration failed. Please try again.';
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('auth/register', $data);
    }

    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            // Set validation rules
            $rules = [
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password is required'
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                
                // Debug logging
                log_message('debug', 'Login attempt for email: ' . $email);
                log_message('debug', 'Expected: terrado@gmail.com / siopao123');
                log_message('debug', 'Received email: ' . $email);
                log_message('debug', 'Received password length: ' . strlen($password));
                log_message('debug', 'Expected password length: ' . strlen('siopao123'));
                log_message('debug', 'Password match: ' . ($password === 'siopao123' ? 'YES' : 'NO'));
                
                // Test with trimmed values
                $emailTrimmed = trim($email);
                $passwordTrimmed = trim($password);
                log_message('debug', 'Trimmed password match: ' . ($passwordTrimmed === 'siopao123' ? 'YES' : 'NO'));

                // TEMPORARY FIX: Check hardcoded credentials while database is broken
                if ($emailTrimmed === 'terrado@gmail.com' && $passwordTrimmed === 'siopao123') {
                    // Simulate user data
                    $user = [
                        'id' => 1,
                        'name' => 'Terrado User',
                        'email' => 'terrado@gmail.com',
                        'role' => 'admin'
                    ];
                    
                    // Create session data
                    $sessionData = [
                        'user_id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'logged_in' => true
                    ];
                    
                    // Set session data and protect against session fixation
                    session()->set($sessionData);
                    session()->regenerate();
                    session()->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                    
                    // Debug: Verify session was set
                    log_message('debug', 'Session data set: ' . print_r($sessionData, true));
                    log_message('debug', 'Session after setting: ' . print_r(session()->get(), true));
                    
                    // Role-based redirection
                    $role = strtolower($user['role'] ?? '');
                    $target = '/dashboard';
                    if ($role === 'admin') {
                        $target = '/admin/dashboard';
                    } elseif ($role === 'teacher') {
                        $target = '/teacher/dashboard';
                    } elseif ($role === 'student') {
                        $target = '/student/dashboard';
                    }

                    log_message('debug', 'Redirecting to role dashboard: ' . $target);
                    return redirect()->to(base_url($target));
                } else {
                    log_message('debug', 'Login failed - credentials do not match');
                    $data['error'] = 'Invalid email or password';
                }
            } else {
                // Debug validation errors
                log_message('debug', 'Validation failed: ' . print_r($this->validator->getErrors(), true));
                $data['validation'] = $this->validator;
            }
        }

        return view('auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully');
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        // Debug session data
        log_message('debug', 'Dashboard accessed. Session data: ' . print_r(session()->get(), true));
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            log_message('debug', 'User not logged in, redirecting to login');
            session()->setFlashdata('error', 'Please login to access the dashboard');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard - WebSystem',
            'user' => [
                'id' => session()->get('user_id'),
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        log_message('debug', 'Dashboard loaded successfully for user: ' . session()->get('email'));
        return view('auth/dashboard', $data);
    }

    public function dashboardSimple()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to access the dashboard');
            return redirect()->to('/login');
        }

        $data = [
            'user' => [
                'id' => session()->get('user_id'),
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        // Use the simple dashboard view without complex templating
        return view('auth/dashboard_simple', $data);
    }
}
