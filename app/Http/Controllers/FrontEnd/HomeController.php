<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function category($category)
    {
        $category = Category::where('slug', $category)->first();
        if(!$category) {
            abort(404);
        }

        return Inertia::render('ListCategory', ['category' => $category->slug, 'categoryName' =>  $category->name]);
    }
    
    public function post($slugPost)
    {
        $post = Post::where('slug', $slugPost)->first();
        if(!$post) {
            abort(404);
        }

        return Inertia::render('Post', ['slug' => $slugPost]);
    }

    public function creator($id)
    {
        $creator = Account::where('code', $id)
            ->where('userable_type', 'Creator')
            ->first();
        if(!$creator) {
            abort(404);
        }

        return Inertia::render('Creator', ['id' => $id  ]);
    }
}
