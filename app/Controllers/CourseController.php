<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CourseController extends BaseController
{
    public function enroll()
    {
        $session = session();

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to(base_url('admin/student-dashboard'));
        }

        $courseId = (int) $this->request->getPost('course_id');
        if ($courseId <= 0) {
            $session->setFlashdata('message', 'Invalid course.');
            return redirect()->to(base_url('admin/student-dashboard'));
        }

        $enrolledKey = 'demo_enrolled';
        $enrolled = $session->get($enrolledKey) ?? [];

        if (! in_array($courseId, $enrolled, true)) {
            $enrolled[] = $courseId;
            $session->set($enrolledKey, $enrolled);
            $session->setFlashdata('message', 'Enrolled successfully (demo).');
        } else {
            $session->setFlashdata('message', 'Already enrolled (demo).');
        }

        return redirect()->to(base_url('admin/student-dashboard'));
    }
}
