<?php

namespace App\Http\Controllers\FrontEnd\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreatorController extends Controller
{
    public function listPosts()
    {
        return Inertia::render('Creater/ListPost');
    }
}
