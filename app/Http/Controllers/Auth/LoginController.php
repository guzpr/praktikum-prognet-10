<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Master\Users;
use Hash;
use Mail;
use Session;
use App\Mail\VerifyMail;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function showLoginForm()
    {
        return view('shop.auth.login');
    }

    public function login(Request $request)
    {
      $this->validate($request, [
        'email'   => 'required',
        'password' => 'required'
      ]);

      if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        if(Auth::guard('user')->user()->status == '0'){
          Auth::guard('user')->logout();
          return redirect()->back()->withWarning('Please verify your account first');
        } else {
          return redirect(route('shop.home'));
        }
      }

      return redirect()->back()->withWarning('Error credential');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('shop.auth.login');
    }

    public function showRegisterForm()
    {
        return view('shop.auth.register');
    }

    public function register(Request $request){
        $user = new Users;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->token = str_random(40);
        $user->status = 0;
        $user->save();
        Mail::to($user->email)->send(new VerifyMail($user));
        return redirect()->route('shop.auth.login')->withSuccess( 'Successfully register account. Please read our email to verify your account' );
    }

    public function verifyUser($token){

        $verifyUser = Users::where('token', $token)->first();
        if(isset($verifyUser) ){
            if(!$verifyUser->status) {
                $verifyUser->status = 1;
                $verifyUser->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->withWarning("Sorry your email cannot be identified.");
        }

        return redirect('/login')->withSuccess($status);
    }
}
