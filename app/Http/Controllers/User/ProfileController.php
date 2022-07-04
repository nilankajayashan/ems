<?php

namespace App\Http\Controllers\User;

use App\Classes\Calculation;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function profile_data(){
        $user = User::find(Auth::user()->user_id);
//        leave details
        $oneYearComplete = false;
        $sixMonthComplete = false;
        $insideSixMonth = false;

        $joinDate = $user['join_date'];

        $calculation = new Calculation();
        if ($calculation->getDifference($joinDate,12)){
            $oneYearComplete = true;
        }
        else{
            if ($calculation->getDifference($joinDate,6)){
                $sixMonthComplete = true;
            }
            else{
                $insideSixMonth = true;
            }
        }
// leave count
        $sql = "SELECT(SELECT COUNT(*) FROM annual_leaves WHERE user_id={$user['user_id']}) AS annual_leaves,(SELECT COUNT(*) FROM casual_leaves WHERE user_id={$user['user_id']}) AS casual_leaves,(SELECT COUNT(*) FROM half_day_leaves WHERE user_id={$user['user_id']}) AS half_day_leaves,(SELECT COUNT(*) FROM sick_leaves WHERE user_id={$user['user_id']}) AS sick_leaves";
       $leave_count = DB::select($sql);
        return view('dashboard', [
            'state' => 'profile',
            'user_data' => $user,
            'oneYearComplete' => $oneYearComplete,
            'sixMonthComplete' => $sixMonthComplete,
            'insideSixMonth' => $insideSixMonth,
            'leave_count' => $leave_count[0],
        ]);
    }

    public function edit_profile(Request $req){
        if ($req->hasFile('profile_image')) {

            $req->validate([
                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);

            $user = User::find(Auth::user()->user_id);
            $user_names = explode(" ", $req->input('full_name'));
            if (count($user_names) > 1) {
                $user->last_name = $user_names[1];
            }
            $user->first_name = $user_names[0];

            if ($user->profile_image != null){
                $file =public_path('Profile_Images/'.$req->input('division').'/'.$user->profile_image);
                File::delete($file);
            }

            $file = $req->file('profile_image');
            $destinationPath = 'Profile_Images/'.$req->input('division');
            $originalFile = $file->getClientOriginalName();
            $file->move($destinationPath, $originalFile);
            $user->profile_image = $originalFile;
            $user->save();

        }else{
            $user = User::find(Auth::user()->user_id);
            $user_names = explode(" ", $req->input('full_name'));
            if (count($user_names) > 1) {
                $user->last_name = $user_names[1];
            }

            $user->first_name = $user_names[0];
            $user->save();
        }

        return redirect()->back();
    }

    // leave request

    public function leave_data(){
        $user = User::find(Auth::user()->user_id);
        $join_date = $user->join_date;

    }


}
