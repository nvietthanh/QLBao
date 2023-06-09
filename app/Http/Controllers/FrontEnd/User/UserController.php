<?php

namespace App\Http\Controllers\FrontEnd\User;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Conversation;
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

    public function message($id = null)
    {
        $accountResult = '';
        
        if($id) {
            $account = Account::where('id', $id)->first();

            $accountResult = [
                'account_id' => $account->id,
                'account_name' => $account->accountProfile->first_name . ' ' .$account->accountProfile->last_name,
                'account_image' => $account->accountProfile->image,
                'is_account_send' => '',
                'status' => '',
                'last_message' => '',
                'last_message_time' => ''
            ];
        }

        return Inertia::render('User/ListMessage', ['account_message_id' => $id, 'accountSelect' => $accountResult]);
    }
}
