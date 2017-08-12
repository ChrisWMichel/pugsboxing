<?php

namespace App\Http\Controllers\Auth;

use App\HeaderPhoto;
use App\Http\Controllers\Controller;
use App\MainLayout;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout() {
        Auth::logout();

        $phone = MainLayout::select('phone')->first();
        $photos = HeaderPhoto::where('visible', 1)->get();

        return view('layouts.public_layout', compact('photos', 'phone'));
    }


    // use this method to load up the calendar in the /admin page
   /* protected function redirectTo()
    {
        return '/path';
    }*/
}
