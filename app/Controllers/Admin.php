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

        // Try to load real stats from the database, but guard to avoid errors if DB/tables are missing
        $stats = [
            'totalUsers' => 0,
            'totalCourses' => 0,
            'activeTeachers' => 0,
        ];

        try {
            $db = \Config\Database::connect();

            // Helper closure to check table existence in MySQL/MariaDB
            $hasTable = static function ($db, string $table): bool {
                try {
                    $res = $db->query("SHOW TABLES LIKE '" . $db->escapeString($table) . "'");
                    return $res && method_exists($res, 'getNumRows') && $res->getNumRows() > 0;
                } catch (\Throwable $e) {
                    return false;
                }
            };

            if ($hasTable($db, 'users')) {
                $stats['totalUsers'] = (int) $db->table('users')->countAll();
                // Count teachers by role if role column exists
                try {
                    $stats['activeTeachers'] = (int) $db->table('users')->where('role', 'teacher')->countAllResults();
                } catch (\Throwable $e) {
                    // ignore; keep default 0
                }
            }

            if ($hasTable($db, 'courses')) {
                $stats['totalCourses'] = (int) $db->table('courses')->countAll();
            }
        } catch (\Throwable $e) {
            // Silently ignore DB issues for now
            log_message('debug', 'Admin stats DB fetch skipped: ' . $e->getMessage());
        }

        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
        ];

        return view('admin/dashboard', $data);
    }
}
