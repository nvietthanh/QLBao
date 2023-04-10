<?php

namespace App\Http\Controllers\FrontEnd\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function formLogin()
    {
        return Inertia::render('Admin/Auth/Login');
    }
}
