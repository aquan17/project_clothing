<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
//   protected function authenticated(Request $request, $user)
//     {
//         // Redirect về trang trước đó hoặc home nếu không có
//         return redirect()->intended($request->input('redirect', '/'));
//     }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Debug: Log query parameter và input redirect
        Log::info('Query redirect: ' . $request->query('redirect', 'none'));
        Log::info('Input redirect: ' . $request->input('redirect', 'none'));
        Log::info('App URL: ' . url('/'));


        // Chỉ ghi đè nếu session chưa có 'url.intended'
        if (!session()->has('url.intended')) {
            $redirectUrl = urldecode($request->input('redirect', $request->query('redirect', '')));
            if ($redirectUrl) {
                session()->put('url.intended', $redirectUrl);
            }
        }
        // Log::info('Decoded redirect URL: ' . $redirectUrl);
        // Log::info('Saved intended URL: ' . $redirectUrl);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            Log::info('User logged in: ' . Auth::user()->name);
            session()->flash('user_name', Auth::user()->name);


            // Log URL intended
            Log::info('Intended URL: ' . session('url.intended', 'none'));

            return redirect()->intended($this->redirectTo);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}
