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
        return Inertia::render('Admin/Category/ListCategory');
    }

    public function listHagtag()
    {
        return Inertia::render('Admin/Category/ListPost');
    }

    public function listPost()
    {
        return Inertia::render('Admin/Post/ListPost');
    }

    public function listReport()
    {
        return 1;
    }
}
