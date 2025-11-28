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
        if (!session()->get('isLoggedIn')) {
            $config = config('App');
            return redirect()->to(rtrim($config->baseURL, '/') . '/login');
        }

        $data = [
            'name' => session()->get('name') ?? 'User',
            'email' => session()->get('email') ?? '',
            'role' => session()->get('role') ?? 'user',
        ];

        return view('auth/dashboard', $data);
    }
}
