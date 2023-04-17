<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\HagTag;
use App\Models\Post;
use Illuminate\Http\Request;
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

        return Inertia::render('ListPostCategory', ['category' => $category->slug, 'categoryName' =>  $category->name]);
    }
    
    public function post($slugPost)
    {
        $post = Post::where('slug', $slugPost)
                ->where('is_approved', 1)
                ->where('status', 1)
                ->first();
                
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

    public function listPostHagtag($slug)
    {
        $hagtag = HagTag::where('slug', $slug)->first();
        if(!$hagtag) {
            abort(404);
        }

        return Inertia::render('ListPostHagtag', ['hagtag' => $slug, 'hagtagName' => $hagtag->name]); 
    }

    public function termOfUse()
    {
        return Inertia::render('TermOfUse');
    }
}
