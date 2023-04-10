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

    public function listUser()
    {
        return Inertia::render('Admin/User/ListUser');
    }

    public function listCategory()
    {
        return 1;
    }

    public function listHagtag()
    {
        return 1;
    }

    public function listPost()
    {
        return 1;
    }

    public function listReport()
    {
        return 1;
    }
}
