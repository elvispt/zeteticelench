<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repos\Unsplash\Unsplash;
use App\Repos\Unsplash\UnsplashApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/notes';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $unsplash = new Unsplash();
        return view('auth.login', [
            'unsplash' => $unsplash->getUnsplashFeaturedImage(new UnsplashApi()),
        ]);
    }
}
