<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        // $this->middleware('guest:accounts')->except('logout');
    }

    public function login(Request $request)
    {
        // Check OTP
        $email = $request->email;
        $password = $request->password;
        $user = Account::whereEmail($email)->where('type_signup', null)->first();
        if(!$user) {
            $errors = [
                'email' => 'Email không tồn tại trong hệ thống'
            ];

            return response()->json(['errors' => $errors], 422);
        }
        else {
            if (!Hash::check($password, $user->password)) {
                $errors = [
                    'password' => 'Mật khẩu không chính xác'
                ];

                return response()->json(['errors' => $errors], 422);
            }
        }

        if (!$user->status) {
            $errors = [
                'email' => 'Tài khoản đã bị khóa đến '. Carbon::parse($user->status_expires_at)->format('Y-m-d H:i')
            ];

            return response()->json(['errors' => $errors], 422);
        }
        // $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';

        // if (!preg_match($regex, $password)) {
        //     $errors = [
        //         'password' => 'Mật khẩu không đúng định dạng'
        //     ];
        //     return response()->json(['errors' => $errors], 422);
        // }
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            return $this->sendLoginResponse($request);
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        
        return $this->sendFailedLoginResponse($request);
    }
    
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }
    
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        
        $this->clearLoginAttempts($request);
        
        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        return response()->json(200);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('accounts');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('home');
    }

    protected function changePassword(ChangePasswordRequest $request)
    {
        $request->validated();
        $password = $request->password;
        $new_password = $request->new_password;
        $user = auth('accounts')->user();

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

    public function loginSocial($provider, Request $request)
    {
        $request->session()->put('redirect_path', $request->url);
        return Socialite::driver($provider)->redirect();
    }

    public function loginSocialCallback($provider, Request $request)
    {
        $redirect_path = $request->session()->get('redirect_path') ?? route('home');

        $accountSocial = Socialite::driver($provider)->user();

        $account = Account::where('email', $accountSocial->email)->first();

        if(!$account) {
            do {
                $code = rand(10000000, 99999999);
            }
            while(Account::where('code', $code)->first());

            $account = Account::create([
                'code' => $code,
                'email' => $accountSocial->email,
                'password' => '',
                'userable_type' => 'Reader',
                'type_signup' => $provider
            ]);

            $account->accountProfile()->create([
                'first_name' => $accountSocial->user['family_name'] ?? '',
                'last_name' => $accountSocial->user['given_name'],
                'image' => $accountSocial->avatar,
                'description' => '',
                'remark' => '',
            ]);
        }
        else {
            $account->accountProfile()->update([
                'first_name' => $accountSocial->user['family_name'] ?? '',
                'last_name' => $accountSocial->user['given_name'],
                'image' => $accountSocial->avatar,
                'description' => '',
                'remark' => '',
            ]);
        }

        auth('accounts')->login($account);

        $request->session()->put('auth.password_confirmed_at', time());
        
        Session::forget('redirect_path');

        return redirect()->to($redirect_path);
    }
}
