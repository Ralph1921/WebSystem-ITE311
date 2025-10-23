<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel; 
use CodeIgniter\Controller;

class Course extends BaseController 
{
    protected $enrollmentModel;
    protected $courseModel; 

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
    }
    public function index()
    {
        return view('welcome_message'); 
    }


    public function enroll()
    {
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON(['status' => 'error', 'message' => 'Method Not Allowed or Not an AJAX request']);
        }

    
        $userId = session()->get('user_id'); 
        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in.']);
        }

        $courseId = $this->request->getPost('course_id');

        if (empty($courseId) || !is_numeric($courseId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid Course ID provided.']);
        }

        $courseId = (int)$courseId;

        if ($this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON(['status' => 'info', 'message' => 'You are already enrolled in this course.']);
        }

        $data = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'), 
        ];

        $enrollmentId = $this->enrollmentModel->enrollUser($data); 

        if ($enrollmentId) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Successfully enrolled in the course.', 'enrollment_id' => $enrollmentId]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to enroll in the course.', 'errors' => $this->enrollmentModel->errors()]);
        }
    }
}