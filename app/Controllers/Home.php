<?php
declare(strict_types=1);

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Render the homepage.
     */
    public function index(): string
    {
        return view('homepage_new');
    }

    /**
     * Render the about page.
     */
    public function about(): string
    {
        return view('about');
    }

    /**
     * Render the contact page.
     */
    public function contact(): string
    {
        return view('contact');
    }

    /**
     * Render the test page.
     */
    public function test(): string
    {
        return view('test');
    }
}
