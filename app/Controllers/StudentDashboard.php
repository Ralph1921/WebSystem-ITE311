<?php namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class StudentDashboard extends BaseController
{
    protected $courseModel;
    protected $enrollModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollModel = new EnrollmentModel();
    }

    // Dashboard main page
    public function index()
    {
        $userId = session()->get('user_id') ?? 1;

        $enrollments = $this->enrollModel
                            ->select('courses.title, courses.description, courses.status')
                            ->join('courses', 'courses.id = enrollments.course_id')
                            ->where('enrollments.user_id', $userId)
                            ->findAll();

        $data = [
            'title'           => 'Student Dashboard',
            'totalCourses'    => $this->courseModel->countAllResults(false),
            'myEnrollments'   => count($enrollments),
            'activeCourses'   => $this->courseModel->where('status', 'active')->countAllResults(false),
            'enrollments'     => $enrollments,
        ];

        return view('student/dashboard', $data);
    }

    // Show all courses page
    public function courses()
    {
        $data = [
            'title' => 'Available Courses',
            'courses' => $this->courseModel->findAll(),
        ];
        return view('student/courses', $data);
    }

    // Enroll in a course
    public function enroll($courseId)
    {
        $userId = session()->get('user_id') ?? 1;

        // Prevent duplicate enrollment
        $exists = $this->enrollModel->where('user_id', $userId)
                                    ->where('course_id', $courseId)
                                    ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Already enrolled.');
        }

        $this->enrollModel->insert([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/student/dashboard')->with('message', 'Enrolled successfully.');
    }
}
