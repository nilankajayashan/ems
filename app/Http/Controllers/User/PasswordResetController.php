<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function password_reset(Request $request){
        if ($request->input('password') == $request->input('re_password')){

            DB::table('users')
                ->where('user_id', Auth::user()->user_id)
                ->update([
                    'password' => bcrypt($request->input('password')),
                ]);

            return redirect()->route('logout',);
        }else{
            return redirect()->route('dashboard',['state' => 'change-password'])->with(
                [
                    'state' => false,
                    'message' => "Password Reset Error..."
                ]);
        }
    }
}
