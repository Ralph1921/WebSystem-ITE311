<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home - Learning Management System',
            'page_title' => 'Welcome to LMS',
            'features' => [
                [
                    'icon' => 'bi-book-fill',
                    'title' => 'Interactive Courses',
                    'description' => 'Access a wide range of courses designed by expert instructors.'
                ],
                [
                    'icon' => 'bi-people-fill',
                    'title' => 'Expert Instructors',
                    'description' => 'Learn from experienced professionals in various fields.'
                ],
                [
                    'icon' => 'bi-graph-up',
                    'title' => 'Track Progress',
                    'description' => 'Monitor your learning progress with detailed analytics.'
                ],
                [
                    'icon' => 'bi-award-fill',
                    'title' => 'Certificates',
                    'description' => 'Earn certificates upon successful completion of courses.'
                ]
            ]
        ];

        return view('index', $data); // loads app/Views/index.php
    }

    public function about()
    {
        $data = [
            'title' => 'About Us - Learning Management System',
            'page_title' => 'About Our LMS',
            'mission' => 'To provide accessible, high-quality education through innovative technology.',
            'vision' => 'To be the leading platform for online learning and skill development.',
            'team' => [
                [
                    'name' => 'Dr. Sarah Johnson',
                    'position' => 'Chief Academic Officer',
                    'description' => 'Expert in educational technology with 15+ years of experience.'
                ],
                [
                    'name' => 'Michael Chen',
                    'position' => 'Lead Developer',
                    'description' => 'Full-stack developer specializing in learning management systems.'
                ],
                [
                    'name' => 'Emily Rodriguez',
                    'position' => 'UX Designer',
                    'description' => 'User experience designer focused on creating intuitive learning interfaces.'
                ]
            ]
        ];

        return view('about', $data); // loads app/Views/about.php
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us - Learning Management System',
            'page_title' => 'Get in Touch',
            'contact_info' => [
                'email'   => 'info@lms-terrado.com',
                'phone'   => '+63 912 345 6789',
                'address' => '123 Education Street, Manila, Philippines 1000',
                'hours'   => 'Monday - Friday: 9:00 AM - 6:00 PM (PST)'
            ]
        ];

        return view('contact', $data); // loads app/Views/contact.php
    }

    public function test()
    {
        return view('test'); // loads app/Views/test.php
    }
}
