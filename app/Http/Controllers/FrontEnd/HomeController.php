<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\HagTag;
use App\Models\Notice;
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
    
    public function post($slugPost, $noticeId = null)
    {
        $currentAccount = auth('accounts')->user();

        $post = Post::where('slug', $slugPost)
                ->where('is_approved', 1)
                ->where('status', 1)
                ->first();

        if(!$post) {
            abort(404);
        }

        if($currentAccount && $noticeId) {
            $notice = Notice::find($noticeId);

            $notice->noticeAccount()->updateExistingPivot($currentAccount->id, ['read_at' => now()]);
        }

        return Inertia::render('Post', ['slug' => $slugPost, 'title' => $post->title]);
    }

    public function creator($id)
    {
        $creator = Account::where('code', $id)
            ->where('userable_type', 'Creator')
            ->first();
        if(!$creator) {
            abort(404);
        }

        return Inertia::render('Creator', [
            'id' => $id,
            'name' => $creator->accountProfile->first_name . ' ' . $creator->accountProfile->last_name
        ]);
    }

    public function listPostHagtag($slug)
    {
        $hagtag = HagTag::where('slug', $slug)->first();
        if(!$hagtag) {
            abort(404);
        }

        return Inertia::render('ListPostHagtag', ['hagtag' => $slug, 'hagtagName' => $hagtag->name]); 
    }

    public function search($search)
    {
        return Inertia::render('ListSearch', ['search' => $search]);
    }

    public function termOfUse($noticeId = null)
    {
        $currentAccount = auth('accounts')->user();

        if($currentAccount) {
            $notice = Notice::find($noticeId);

            $notice->noticeAccount()->updateExistingPivot($currentAccount->id, ['read_at' => now()]);
        }

        return Inertia::render('TermOfUse');
    }

    public function privatePolicy($noticeId = null)
    {
        $currentAccount = auth('accounts')->user();

        if($currentAccount) {
            $notice = Notice::find($noticeId);

            $notice->noticeAccount()->updateExistingPivot($currentAccount->id, ['read_at' => now()]);
        }

        return Inertia::render('PrivatePolicy');
    }

    public function aboutUs()
    {
        return Inertia::render('AboutUs');
    }
}
