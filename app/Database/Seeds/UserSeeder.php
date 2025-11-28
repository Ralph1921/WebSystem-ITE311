<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin user
            [
                'username'   => 'admin',
                'email'      => 'admin@lms.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'Admin',
                'last_name'  => 'User',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Instructor users
            [
                'username'   => 'instructor1',
                'email'      => 'instructor1@lms.com',
                'password'   => password_hash('instructor123', PASSWORD_DEFAULT),
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'role'       => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'instructor2',
                'email'      => 'instructor2@lms.com',
                'password'   => password_hash('instructor123', PASSWORD_DEFAULT),
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'role'       => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Student users
            [
                'username'   => 'student1',
                'email'      => 'student1@lms.com',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'first_name' => 'Alice',
                'last_name'  => 'Johnson',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'student2',
                'email'      => 'student2@lms.com',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'first_name' => 'Bob',
                'last_name'  => 'Williams',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'student3',
                'email'      => 'student3@lms.com',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'first_name' => 'Charlie',
                'last_name'  => 'Brown',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder to insert data
        $this->db->table('users')->insertBatch($data);
    }
}
