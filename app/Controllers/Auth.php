<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return view('auth/register', ['validation' => $validation]);
            }

            $db = \Config\Database::connect();
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role') ?? 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $db->table('users')->insert($data);

            session()->setFlashdata('success', 'Registration successful! Please login.');
            $config = config('App');
            return redirect()->to(rtrim($config->baseURL, '/') . '/login');
        }

        return view('auth/register');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            
            $validation->setRules([
                'email' => 'required|valid_email',
                'password' => 'required',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return view('auth/login', ['validation' => $validation]);
            }

            $db = \Config\Database::connect();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $db->table('users')->where('email', $email)->get()->getRowArray();

            if ($user && password_verify($password, $user['password'])) {
                $sessionData = [
                    'userID' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ];
                session()->set($sessionData);

                session()->setFlashdata('success', 'Welcome, ' . $user['name'] . '!');
                $config = config('App');
                return redirect()->to(rtrim($config->baseURL, '/') . '/dashboard');
            } else {
                session()->setFlashdata('error', 'Invalid email or password.');
                $config = config('App');
                return redirect()->to(rtrim($config->baseURL, '/') . '/login');
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        $config = config('App');
        return redirect()->to(rtrim($config->baseURL, '/'));
    }

    public function dashboard()
    {
        // Authorization check - ensure user is logged in
        if (!session()->get('isLoggedIn')) {
            $config = config('App');
            return redirect()->to(rtrim($config->baseURL, '/') . '/login');
        }

        // Get user data from session
        $db = \Config\Database::connect();
        $user_id = session()->get('userID');
        $role = session()->get('role') ?? 'user';
        $name = session()->get('name') ?? 'User';
        $email = session()->get('email') ?? '';

        // Fetch role-specific data
        $data = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ];

        // Add role-specific data based on user's role
        if ($role === 'admin') {
            // Admin dashboard data
            $data['total_users'] = $db->table('users')->countAllResults();
            $data['total_courses'] = $db->table('courses')->countAllResults();
            $data['recent_users'] = $db->table('users')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray();
        } elseif ($role === 'instructor' || $role === 'teacher') {
            // Instructor/Teacher dashboard data
            $data['my_courses'] = $db->table('courses')->where('instructor_id', $user_id)->get()->getResultArray();
            $data['course_count'] = count($data['my_courses']);
        } elseif ($role === 'student') {
            // Student dashboard data
            $data['enrolled_courses'] = $db->table('enrollments')
                ->select('enrollments.*, courses.title, courses.description')
                ->join('courses', 'courses.id = enrollments.course_id')
                ->where('enrollments.student_id', $user_id)
                ->get()->getResultArray();
            $data['course_count'] = count($data['enrolled_courses']);
        }

        // Pass data to the view
        return view('auth/dashboard', $data);
    }
}
