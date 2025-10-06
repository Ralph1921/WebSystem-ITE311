<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Lessons for Web Development Course (course_id = 1)
            [
                'course_id' => 1,
                'title' => 'HTML Basics',
                'content' => 'Learn the fundamental structure of HTML documents, tags, and elements.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'course_id' => 1,
                'title' => 'CSS Styling',
                'content' => 'Master CSS selectors, properties, and layout techniques.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'course_id' => 1,
                'title' => 'JavaScript Fundamentals',
                'content' => 'Introduction to JavaScript programming, variables, functions, and DOM manipulation.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Lessons for Database Management Course (course_id = 2)
            [
                'course_id' => 2,
                'title' => 'Database Design',
                'content' => 'Learn entity-relationship modeling and database normalization.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'course_id' => 2,
                'title' => 'SQL Queries',
                'content' => 'Master SELECT, INSERT, UPDATE, DELETE statements and advanced queries.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Lessons for PHP Programming Course (course_id = 3)
            [
                'course_id' => 3,
                'title' => 'PHP Syntax and Variables',
                'content' => 'Learn PHP syntax, data types, variables, and operators.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'course_id' => 3,
                'title' => 'PHP Functions and Arrays',
                'content' => 'Understanding PHP functions, arrays, and control structures.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Lessons for CodeIgniter Framework Course (course_id = 4)
            [
                'course_id' => 4,
                'title' => 'CodeIgniter MVC Architecture',
                'content' => 'Understanding the Model-View-Controller pattern in CodeIgniter.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'course_id' => 4,
                'title' => 'Database Migrations',
                'content' => 'Learn how to create and manage database migrations in CodeIgniter.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert lessons
        $this->db->table('lessons')->insertBatch($data);
    }
}
