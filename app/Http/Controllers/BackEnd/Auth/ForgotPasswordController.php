<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailForgotPassword;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ],[
            'required' => 'Trường :attribute là bắt buộc',
            'email' => 'Trường này phải là email'
        ], [ 'email' => 'email' ]);
        
        $account = Account::whereEmail($request->email)->first();
        if(!$account) {
            $errors = [
                'email' => ['Email không tồn tại trong hệ thống']
            ];
            return response()->json(['errors' => $errors], 422);
        }

        $otp = rand(100000, 999999);
        $optExpiresAt = Carbon::now()->addMinutes(5);

        $account->otp = $otp;
        $account->otp_expires_at = $optExpiresAt;
        $account->save();

        SendMailForgotPassword::dispatch($account);

        return response()->json(true);
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'integer']
        ],[
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là số nguyên',
            'email' => 'Trường này phải là email'
        ], [ 'otp' => 'OTP' ]);

        $account = Account::whereEmail($request->email)->first();
        if($account->otp != $request->otp) {
            $errors = [
                'otp' => ['Mã OTP nhập không chính xác']
            ];
            return response()->json(['errors' => $errors], 422);
        }
        else {
            if( now() <= $account->otp_expires_at) {
                $account->otp = null;
                $account->otp_expires_at = null;
                $account->save();

                return response()->json(true);
            }
            else {
                $errors = [
                    'otp' => ['Mã OTP đã hết hạn']
                ];
                return response()->json(['errors' => $errors], 422);
            }
        }
    }

    public function changeForgotPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'max:20'],
            'confirm_password' => ['required', 'min:8', 'max:20', 'same:password'],
        ],[
            'required' => 'Trường :attribute là bắt buộc',
            'min' => 'Trường :attribute có tối thiểu :min ký tự',
            'max' => 'Trường :attribute có tối đa :max ký tự',
            'same' => 'Trường :attribute không đúng'
        ], [ 
            'password' => 'mật khẩu',
            'confirm_password' => 'mật khẩu xác nhận'
        ]);

        $account = Account::whereEmail($request->email)->first();
        $account->password = bcrypt($request->password);
        $account->save();

        return response()->json(true);
    }
}
