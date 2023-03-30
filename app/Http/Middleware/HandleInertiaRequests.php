<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $categories = $categories = Category::select(['name', 'slug'])->get();
        $account = auth()->guard('accounts')->user();
        $user = auth()->user();
        return array_merge(parent::share($request), [
            'categories' => $categories,
            'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            'auth' => [
                'account' => $account ? $account->accountProfile->only('first_name', 'last_name', 'image') : '',
                'user' => $user ? $user->only('id', 'name', 'email') : '',
            ],
        ]);
    }
}
