<?php

namespace App\Http\Controllers\FrontEnd\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function myProfile()
    {
        return Inertia::render('User/MyProfile');
    }

    public function lisFollows()
    {
        return Inertia::render('User/ListFollow');
    }

    public function listReads()
    {
        return Inertia::render('User/ListRead');
    }

    public function listSaves()
    {
        return Inertia::render('User/ListSave');
    }
}
