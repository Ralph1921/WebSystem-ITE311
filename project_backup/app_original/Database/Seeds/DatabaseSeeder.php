<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run seeders in order to maintain foreign key relationships
        $this->call('UserSeeder');
        $this->call('CourseSeeder');
        $this->call('LessonSeeder');
        $this->call('QuizSeeder');
        $this->call('EnrollmentSeeder');
    }
}
