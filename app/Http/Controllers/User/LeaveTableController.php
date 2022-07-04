<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\b;

class LeaveTableController extends Controller
{
    public function leave_table(Request $request){
        switch ($request->input('leave_type')){
            case 'annual':
                $table = 'annual_leaves';
                $table_name = 'annual leaves';
                break;
            case 'casual':
                $table = 'casual_leaves';
                $table_name = 'casual leaves';
                break;
            case 'half_day':
                $table = 'half_day_leaves';
                $table_name = 'half day leaves';
                break;
            case 'sick':
                $table = 'sick_leaves';
                $table_name = 'sick leaves';
                break;
            default:
                $table = null;
                $table_name = null;
                break;
        }
        if($table == null){
            return view('Components/body/user/data_table/leave_table',[
                'leave_table_name' => $table_name,
            ]);
        }else{
            $leave_data = DB::select("select * from {$table} where user_id = ? order by leave_date DESC" , [Auth::user()->user_id]) ;
            return view('Components/body/user/data_table/leave_table',[
                'leave_data' => $leave_data,
                'leave_table_name' => $table_name,
                'user_name' => Auth::user()->first_name ." ". Auth::user()->last_name  ,
            ]);
        }


    }
}
