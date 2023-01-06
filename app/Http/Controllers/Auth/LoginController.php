<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
      protected $redirectTo = RouteServiceProvider::HOME;

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
            $this->middleware('guest')->except('logout');
      }

      public function login(Request $request)
      {
            if ($request->isMethod('post')) {
                  $data = $request->all();
                  $roles = [
                        'email' => 'required|email|max:255',
                        'password' => 'required',
                  ];
                  $customessage = [
                        'email.required' => 'Email is required',
                        'email.email' => 'Email is not vaild',
                        'password.required' => 'Password is required',
                  ];
                  $this->validate($request, $roles, $customessage);

                  
                  if (!Auth::attempt(['email' => $data['email'] , 'password' => $data['password']])) {
                     return redirect()->back()->with('toast_error', 'Your email or password is incorrect!');
                  }
                  // dd(Auth::attempt(['password' => $data['password']]));
                  if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'Aktif'])) {
                        if(auth()->user()->role == "Super Admin" || auth()->user()->role == "Admin") {
                              return redirect()->route('dashboard');
                        }
                        return redirect()->route('events.index');
                  } else {
                        // Session::flash('error_message','You are not Active by Admin');
                        return redirect()->back()->with('toast_error', 'Your account has not been verified!');
                  }
            }
            // return view('admin.admin_login');
      }
}
