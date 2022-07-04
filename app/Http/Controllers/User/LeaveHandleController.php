<?php

namespace App\Http\Controllers\User;

use App\Classes\Calculation;
use App\Http\Controllers\Controller;
use App\Mail\LeaveRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LeaveHandleController extends Controller
{
    public function leave_details(){
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
        $sql = "SELECT(SELECT COUNT(*) FROM annual_leaves WHERE user_id={$user['user_id']}) AS annual_leaves,(SELECT COUNT(*) FROM casual_leaves WHERE user_id={$user['user_id']}) AS casual_leaves,(SELECT COUNT(*) FROM half_day_leaves WHERE user_id={$user['user_id']}) AS half_day_leaves,(SELECT COUNT(*) FROM sick_leaves WHERE user_id={$user['user_id']}) AS sick_leaves";
        $leave_count = DB::select($sql);
        return view('dashboard', [
            'state' => 'leave',
            'oneYearComplete' => $oneYearComplete,
            'sixMonthComplete' => $sixMonthComplete,
            'insideSixMonth' => $insideSixMonth,
            'leave_count' => $leave_count[0],

        ]);
    }

    public function request_leave(Request $request){
        switch ($request->input('leave_type')){
            case 'annual_leave':
                $table = 'annual_leaves';
                break;
            case 'casual_leave':
                $table = 'casual_leaves';
                break;
            case 'half_day':
                $table = 'half_day_leaves';
                break;
            case 'sick_leave':
                $table = 'sick_leaves';
                break;
            default:
                $table = null;
                break;
        }
        $user = Auth::user()->user_id;
        $day = $request->input('date');
        $sql = "SELECT(SELECT COUNT(*) FROM annual_leaves WHERE user_id={$user} and leave_date='{$day}') as annual,(SELECT COUNT(*) FROM casual_leaves WHERE user_id={$user} and leave_date='{$day}') as casual,(SELECT COUNT(*) FROM half_day_leaves WHERE user_id={$user} and leave_date='{$day}') as half,(SELECT COUNT(*) FROM sick_leaves WHERE user_id={$user} and leave_date='{$day}') as sick";
        $leave_count = DB::select($sql);
        $count = $leave_count[0]->annual + $leave_count[0]->casual + $leave_count[0]->half + $leave_count[0]->sick;
        if($count <=0){
            if ($table == null){
                return redirect()->route('leave',['state' => 'leave'])
                    ->with(['status' => 'error']);
            }
            elseif ($table == 'half_day_leaves'){
                DB::table($table)->insert([
                    'user_id' => Auth::user()->user_id,
                    'leave_date' => $request->input('date'),
                    'leave_time' => $request->input('time'),
                    'reason' => $request->input('reason'),
                    'status' => PENDING,
                ]);

                //send mail
                $send = new Mail();
                $send->send_mail();

                return redirect()->route('leave',['state' => 'leave'])
                    ->with([
                        'status' => 'success',
                        'date' => $request->input('date'),
                    ]);
            }
            else{
                DB::table($table)->insert([
                    'user_id' => Auth::user()->user_id,
                    'leave_date' => $request->input('date'),
                    'reason' => $request->input('reason'),
                    'status' => PENDING,
                ]);

                //send mail
                Mail::to(Auth::user()->email)->send(new LeaveRequest());


                return redirect()->route('leave',['state' => 'leave'])
                    ->with([
                        'status' => 'success',
                        'date' => $request->input('date'),
                    ]);

            }
        }else{
            return redirect()->route('leave',['state' => 'leave'])
                ->with(['status' => 'same_day']);
        }
    }
}
