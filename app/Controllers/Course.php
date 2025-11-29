<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;

class Course extends BaseController
{
    protected $enrollmentModel;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Create a new course
     */
    public function create()
    {
        // Check if user is logged in and is instructor/teacher
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }

        $role = session()->get('role');
        if ($role !== 'instructor' && $role !== 'teacher') {
            return redirect()->to(site_url('/dashboard'))->with('error', 'Only instructors can create courses.');
        }

        if ($this->request->getMethod() === 'POST') {
            $title = $this->request->getPost('title');
            $description = $this->request->getPost('description');
            $instructor_id = session()->get('userID');

            $db = \Config\Database::connect();
            $data = [
                'title' => $title,
                'description' => $description,
                'instructor_id' => $instructor_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($db->table('courses')->insert($data)) {
                session()->setFlashdata('success', 'Course created successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to create course.');
            }

            return redirect()->to(site_url('/dashboard'));
        }
    }

    /**
     * Handle AJAX enrollment request
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function enroll()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not logged in'
            ])->setStatusCode(401);
        }

        // Get course_id from POST request
        $course_id = $this->request->getPost('course_id');

        if (!$course_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course ID is required'
            ])->setStatusCode(400);
        }

        $user_id = session()->get('userID');

        // Check if user is already enrolled
        if ($this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are already enrolled in this course'
            ])->setStatusCode(400);
        }

        // Insert new enrollment record
        $enrollment_date = date('Y-m-d H:i:s');
        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => $enrollment_date
        ];

        if ($this->enrollmentModel->enrollUser($data)) {
            // Get the enrolled course details
            $db = \Config\Database::connect();
            $course = $db->table('courses')->where('id', $course_id)->get()->getRowArray();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully enrolled in the course',
                'course' => [
                    'id' => $course['id'],
                    'title' => $course['title'],
                    'description' => $course['description'],
                    'enrollment_date' => $enrollment_date
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to enroll in the course'
        ])->setStatusCode(500);
    }
}

