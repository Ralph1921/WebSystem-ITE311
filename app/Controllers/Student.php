<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Student extends Controller
{
    protected CourseModel $courseModel;
    protected EnrollmentModel $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    private function ensureAuthorized(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        $session = session();

        if (!$session->get('logged_in')) {
            $session->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('/login'));
        }

        $userRole = strtolower((string) $session->get('role'));

        if ($userRole !== 'student') {
            return redirect()->to(base_url($this->routeForRole($userRole)));
        }

        return null;
    }

    private function routeForRole(string $role): string
    {
        return match ($role) {
            'admin'   => '/admin/dashboard',
            'teacher' => '/teacher/dashboard',
            'student' => '/student/dashboard',
            default   => '/dashboard',
        };
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $session = session();
        $userId = $session->get('user_id');

        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($userId);
        $allCourses = $this->courseModel->findAll();

        $enrolledCourseIds = array_column($enrolledCourses, 'id');
        $availableCourses = array_filter($allCourses, function ($course) use ($enrolledCourseIds) {
            return !in_array($course['id'], $enrolledCourseIds);
        });

        $data = [
            'title'            => 'Student Dashboard',
            'enrolledCourses'  => $enrolledCourses,
            'availableCourses' => $availableCourses,
        ];

        return view('student_dashboard', $data);
    }
}