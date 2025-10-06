<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Quiz for HTML Basics lesson (lesson_id = 1)
            [
                'lesson_id' => 1,
                'question' => 'What does HTML stand for?',
                'options' => json_encode([
                    'A' => 'HyperText Markup Language',
                    'B' => 'High Tech Modern Language',
                    'C' => 'Home Tool Markup Language',
                    'D' => 'Hyperlink and Text Markup Language'
                ]),
                'answer' => 'A'
            ],
            [
                'lesson_id' => 1,
                'question' => 'Which tag is used to create a hyperlink?',
                'options' => json_encode([
                    'A' => '<link>',
                    'B' => '<a>',
                    'C' => '<href>',
                    'D' => '<url>'
                ]),
                'answer' => 'B'
            ],
            // Quiz for CSS Styling lesson (lesson_id = 2)
            [
                'lesson_id' => 2,
                'question' => 'What does CSS stand for?',
                'options' => json_encode([
                    'A' => 'Computer Style Sheets',
                    'B' => 'Creative Style Sheets',
                    'C' => 'Cascading Style Sheets',
                    'D' => 'Colorful Style Sheets'
                ]),
                'answer' => 'C'
            ],
            // Quiz for JavaScript Fundamentals lesson (lesson_id = 3)
            [
                'lesson_id' => 3,
                'question' => 'Which keyword is used to declare a variable in JavaScript?',
                'options' => json_encode([
                    'A' => 'var',
                    'B' => 'let',
                    'C' => 'const',
                    'D' => 'All of the above'
                ]),
                'answer' => 'D'
            ],
            // Quiz for Database Design lesson (lesson_id = 4)
            [
                'lesson_id' => 4,
                'question' => 'What is the primary purpose of database normalization?',
                'options' => json_encode([
                    'A' => 'To make the database faster',
                    'B' => 'To reduce data redundancy',
                    'C' => 'To increase storage space',
                    'D' => 'To make queries simpler'
                ]),
                'answer' => 'B'
            ],
            // Quiz for SQL Queries lesson (lesson_id = 5)
            [
                'lesson_id' => 5,
                'question' => 'Which SQL statement is used to retrieve data from a database?',
                'options' => json_encode([
                    'A' => 'GET',
                    'B' => 'SELECT',
                    'C' => 'RETRIEVE',
                    'D' => 'FETCH'
                ]),
                'answer' => 'B'
            ],
            // Quiz for PHP Syntax lesson (lesson_id = 6)
            [
                'lesson_id' => 6,
                'question' => 'What is the correct way to start a PHP script?',
                'options' => json_encode([
                    'A' => '<?php',
                    'B' => '<php',
                    'C' => '<?',
                    'D' => 'Both A and C'
                ]),
                'answer' => 'D'
            ],
            // Quiz for CodeIgniter MVC lesson (lesson_id = 8)
            [
                'lesson_id' => 8,
                'question' => 'What does MVC stand for in CodeIgniter?',
                'options' => json_encode([
                    'A' => 'Model-View-Controller',
                    'B' => 'Multiple-View-Controller',
                    'C' => 'Model-View-Component',
                    'D' => 'Main-View-Controller'
                ]),
                'answer' => 'A'
            ]
        ];

        // Insert quizzes
        $this->db->table('quizzes')->insertBatch($data);
    }
}
