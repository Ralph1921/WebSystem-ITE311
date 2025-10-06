<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Student enrollments (user_id 3, 4, 5 are students)
            [
                'user_id' => 3, // Jane Smith
                'course_id' => 1, // Web Development
                'enrolled_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3, // Jane Smith
                'course_id' => 2, // Database Management
                'enrolled_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 4, // Mike Johnson
                'course_id' => 1, // Web Development
                'enrolled_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 4, // Mike Johnson
                'course_id' => 3, // PHP Programming
                'enrolled_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 5, // Sarah Wilson
                'course_id' => 2, // Database Management
                'enrolled_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 5, // Sarah Wilson
                'course_id' => 4, // CodeIgniter Framework
                'enrolled_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert enrollments
        $this->db->table('enrollments')->insertBatch($data);
    }
}
