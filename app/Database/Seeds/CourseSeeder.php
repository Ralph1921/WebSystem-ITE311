<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Web Systems and Technologies',
                'description' => 'Comprehensive course covering modern web development technologies, frameworks, and best practices for building robust web applications.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Systems Analysis and Design',
                'description' => 'Learn methodologies for analyzing business requirements and designing effective information systems using modern approaches.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Database Management Systems',
                'description' => 'In-depth study of database design, implementation, and management using various database management systems and SQL.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Software Engineering',
                'description' => 'Principles and practices of software engineering including project management, quality assurance, and development methodologies.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Computer Networks',
                'description' => 'Understanding network architecture, protocols, and technologies for modern computer communication systems.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Information Security',
                'description' => 'Comprehensive overview of information security principles, threats, and countermeasures in modern computing environments.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Mobile Application Development',
                'description' => 'Design and development of mobile applications for iOS and Android platforms using modern development frameworks.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Cloud Computing',
                'description' => 'Introduction to cloud computing concepts, services, and deployment models with hands-on experience in cloud platforms.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using the database builder to insert data
        $this->db->table('courses')->insertBatch($data);
    }
}