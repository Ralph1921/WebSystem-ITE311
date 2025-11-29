<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;

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
        return redirect()->to(rtrim($config->baseURL, '/') . '/');
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
            'enrolled_courses' => [],
            'available_courses' => [],
        ];

        // Add role-specific data based on user's role
        try {
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
                $enrollmentModel = new EnrollmentModel();
                $enrolled_courses = $enrollmentModel->getUserEnrollments($user_id);
                $data['enrolled_courses'] = is_array($enrolled_courses) ? $enrolled_courses : [];
                
                // Get all courses from database
                $all_courses = $db->table('courses')->get()->getResultArray();
                $all_courses = is_array($all_courses) ? $all_courses : [];
                
                // Get IDs of already enrolled courses
                $enrolled_course_ids = [];
                if (!empty($data['enrolled_courses'])) {
                    $enrolled_course_ids = array_column($data['enrolled_courses'], 'course_id');
                }
                $enrolled_course_ids = is_array($enrolled_course_ids) ? $enrolled_course_ids : [];
                
                // Filter available courses (those not already enrolled in)
                $data['available_courses'] = [];
                foreach ($all_courses as $course) {
                    if (!in_array($course['id'], $enrolled_course_ids)) {
                        $data['available_courses'][] = $course;
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't crash the page
            log_message('error', 'Dashboard Error: ' . $e->getMessage());
        }

        // Pass data to the view
        return view('auth/dashboard', $data);
    }
}
