<?php

namespace App\Http\Controllers\FrontEnd\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Admin/Dashboard');
    }
}
