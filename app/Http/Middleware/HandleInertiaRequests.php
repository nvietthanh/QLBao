<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\HagTag;
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
        $categories = Category::select(['name', 'slug'])->get();
        $hagtags = HagTag::select(['name', 'slug'])->get();

        $account = auth()->guard('accounts')->user();
        if($account) {
            $account = array_merge(
                $account->accountProfile->only('first_name' , 'last_name', 'image'),
                [
                    'code' => $account->code,
                    'id' => $account->id
                ]
            );
        }

        $user = auth()->user();
        return array_merge(parent::share($request), [
            'categories' => $categories,
            'hagtags' => $hagtags,
            'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            'auth' => [
                'account' => $account ?  : '',
                'user' => $user ? $user->only('id', 'name', 'email', 'profile_photo_path') : '',
            ],
        ]);
    }
}
