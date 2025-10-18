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

    public function manageUsers()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        // Get users from database if available
        $users = [];
        try {
            $db = \Config\Database::connect();
            $hasTable = static function ($db, string $table): bool {
                try {
                    $res = $db->query("SHOW TABLES LIKE '" . $db->escapeString($table) . "'");
                    return $res && method_exists($res, 'getNumRows') && $res->getNumRows() > 0;
                } catch (\Throwable $e) {
                    return false;
                }
            };

            if ($hasTable($db, 'users')) {
                $users = $db->table('users')->get()->getResultArray();
            }
        } catch (\Throwable $e) {
            log_message('debug', 'Admin manage users DB fetch skipped: ' . $e->getMessage());
        }

        $data = [
            'title' => 'Manage Users',
            'users' => $users,
        ];

        return view('admin/manage_users', $data);
    }

    public function manageCourses()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        // Get courses from database if available
        $courses = [];
        try {
            $db = \Config\Database::connect();
            $hasTable = static function ($db, string $table): bool {
                try {
                    $res = $db->query("SHOW TABLES LIKE '" . $db->escapeString($table) . "'");
                    return $res && method_exists($res, 'getNumRows') && $res->getNumRows() > 0;
                } catch (\Throwable $e) {
                    return false;
                }
            };

            if ($hasTable($db, 'courses')) {
                $courses = $db->table('courses')->get()->getResultArray();
            }
        } catch (\Throwable $e) {
            log_message('debug', 'Admin manage courses DB fetch skipped: ' . $e->getMessage());
        }

        $data = [
            'title' => 'Manage Courses',
            'courses' => $courses,
        ];

        return view('admin/manage_courses', $data);
    }

    public function activityLogs()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        // Mock activity logs data - in a real application, this would come from a logs table
        $logs = [
            [
                'id' => 1,
                'user' => 'admin@lms.com',
                'action' => 'User login',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'ip_address' => '127.0.0.1'
            ],
            [
                'id' => 2,
                'user' => 'jane.student@lms.com',
                'action' => 'Course enrollment',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-4 hours')),
                'ip_address' => '127.0.0.1'
            ],
            [
                'id' => 3,
                'user' => 'instructor@lms.com',
                'action' => 'Course created',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'ip_address' => '127.0.0.1'
            ]
        ];

        $data = [
            'title' => 'Activity Logs',
            'logs' => $logs,
        ];

        return view('admin/activity_logs', $data);
    }
}
