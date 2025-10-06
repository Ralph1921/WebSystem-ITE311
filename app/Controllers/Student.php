<?php

namespace App\Controllers;

class Student extends BaseController
{
    private function ensureAuthorized(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (!session('logged_in')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('/login'));
        }
        if (strtolower((string) session('role')) !== 'student') {
            return redirect()->to(base_url($this->routeForRole((string) session('role'))));
        }
        return null;
    }

    private function routeForRole(string $role): string
    {
        $role = strtolower($role);
        return match ($role) {
            'admin' => '/admin/dashboard',
            'teacher' => '/teacher/dashboard',
            'student' => '/student/dashboard',
            default => '/dashboard',
        };
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $data = [
            'title' => 'Student Dashboard',
            'enrollments' => [], // Replace with real enrollments when DB ready
        ];

        return view('student/dashboard', $data);
    }
}
