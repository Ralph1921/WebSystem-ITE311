<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Test extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function hello()
    {
        return 'Hello from CodeIgniter 4! Your installation is working perfectly!';
    }
}
