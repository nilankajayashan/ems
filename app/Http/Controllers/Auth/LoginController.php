<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard';
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
        $input = $request->all();

        $this->validate($request, [
            'user_id' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('user_id', '=', $input['user_id'])->first();
        if ($user === null){
            return redirect()->route('login')
                ->withErrors(
                    [
                        'user_id' => 'Dear Employee, you entered id have not in EMS...!',
                    ]);
        }else{
            if(Auth::attempt(array('user_id' => $input['user_id'], 'password' => $input['password'])))
            {
                //user valid
                //dd(Auth::user());
                return redirect()->route('dashboard',['state'=>'dashboard']);
            }else{
                return redirect()->route('login')->withErrors(['password' => 'Dear Employee, you entered password does not match with your Employee Id...!']);
            }
        }


    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
