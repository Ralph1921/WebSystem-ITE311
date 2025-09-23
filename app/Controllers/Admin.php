<?php

namespace App\Controllers;

class Admin extends BaseController
{
    private function ensureAuthorized(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (!session('logged_in')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('/login'));
        }
        if (strtolower((string) session('role')) !== 'admin') {
            // Redirect user to their own dashboard
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

        // Example data for the admin dashboard
        $data = [
            'title' => 'Admin Dashboard',
            'stats' => [
                'totalUsers' => 0, // Replace with real counts when DB ready
                'totalCourses' => 0,
                'activeTeachers' => 0,
            ],
        ];

        return view('admin/dashboard', $data);
    }
}
