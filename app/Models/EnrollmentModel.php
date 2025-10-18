<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['user_id', 'course_id', 'enrollment_date'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Uncomment if useSoftDeletes is true

    protected $validationRules = [
        'user_id'         => 'required|integer|is_natural_no_zero',
        'course_id'       => 'required|integer|is_natural_no_zero',
        'enrollment_date' => 'permit_empty|valid_date',
    ];
    protected $validationMessages = [
        'user_id'   => ['is_natural_no_zero' => 'A valid User ID is required.'],
        'course_id' => ['is_natural_no_zero' => 'A valid Course ID is required.'],
    ];
    protected $skipValidation = false;
    protected $errors = [];

    public function enrollUser(array $data)
    {
        $userId = (int) ($data['user_id'] ?? 0);
        $courseId = (int) ($data['course_id'] ?? 0);

        if ($userId <= 0 || $courseId <= 0) {
            return false;
        }

        if ($this->isAlreadyEnrolled($userId, $courseId)) {
            $this->errors = ['enrollment_exists' => 'User is already enrolled in this course.'];
            return false;
        }

        if (!isset($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        return $this->insert($data);
    }

    public function getUserEnrollments(int $userId): array
    {
        if ($userId <= 0) {
            return [];
        }

        return $this->select('
                        enrollments.id,
                        enrollments.user_id,
                        enrollments.course_id,
                        enrollments.enrollment_date,
                        enrollments.created_at,
                        enrollments.updated_at,
                        courses.title as course_title,
                        courses.description as course_description,
                        courses.instructor as course_instructor
                    ')
                    ->join('courses', 'courses.id = enrollments.course_id', 'left')
                    ->where('enrollments.user_id', $userId)
                    ->findAll();
    }

    public function isAlreadyEnrolled(int $userId, int $courseId): bool
    {
        if ($userId <= 0 || $courseId <= 0) {
            return false;
        }

        $enrollment = $this->where(['user_id' => $userId, 'course_id' => $courseId])
                           ->first();

        return ($enrollment !== null);
    }
}