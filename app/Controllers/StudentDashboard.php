<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class StudentDashboard extends BaseController
{
    public function index()
    {
        $session = session();

        $enrolled = [
            ['id' => 1, 'title' => 'PHP Fundamentals', 'instructor' => 'Ms. Smith', 'grade' => 'B+'],
            ['id' => 2, 'title' => 'Database 101',   'instructor' => 'Mr. Cruz',  'grade' => 'A-'],
        ];

        $available = [
            ['id' => 101, 'title' => 'Test Subject',      'meta' => 'test'],
            ['id' => 102, 'title' => 'Web Design Basics', 'meta' => 'Instructor: Ms. Park'],
        ];

        $data = [
            'enrolled'  => $enrolled,
            'available' => $available,
            'userName'  => $session->get('user_name') ?? 'Student One',
        ];

        return view('admin/student_dashboard', $data);
    }
}
