<?php

namespace App\Http\Controllers\FrontEnd\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $request->validated();
        $password = $request->password;
        $new_password = $request->new_password;
        $user = auth('web')->user();

        if (!Hash::check($password, $user->password)) {
            $errors = [
                'password' => ['Mật khẩu không chính xác']
            ];
            return response()->json(['errors' => $errors], 422);
        }

        if($password == $new_password) {
            $errors = [
                'new_password' => ['Mật khẩu mới không được trùng mật khẩu cũ']
            ];
            return response()->json(['errors' => $errors], 422);
        }

        $user->update([
            'password' => bcrypt($new_password)
        ]);

        return response()->json(200);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('web')->user();
        
        $user->update([
            'name' => $request->name,
        ]);

        if(!($request->image == $user->profile_photo_path)) {
            $path = $request->file('image') ? Storage::putFile('public/avatars', $request->file('image')) : '';
            $user->update([
                'profile_photo_path' => $path ? Storage::url($path) : ''
            ]);
        }
    }
}
