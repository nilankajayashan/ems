<?php

namespace App\Http\Controllers\User;
use App\Classes\Calculation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $start_state = false;
        $end_state = false;
        $date = date('Y-m-d');
        $attend = DB::select('select * from attendances where user_id = ? and work_date = ?' , [Auth::user()->user_id,$date]);
        if(count($attend) == 0)
        {
            //start karalath naa | end karalath naa
            $start_state = true;
        }elseif ($attend[0]->end_time == null)
        {
            //start karala || end karala naaa
            $end_state = true;
        }

        //check user tasks
        $tasks = DB::select('select * from user_tasks where user_id = ?' , [Auth::user()->user_id]);
        //end check user tasks

        if(!$start_state && !$end_state){
            //start karala | end karala

            //date convert to 12 hours
            $start_time = $attend[0]->start_time ;
            $end_time = $attend[0]->end_time ;

            $start_time = date('h:i:s A', strtotime($start_time));
            $end_time = date('h:i:s A', strtotime($end_time));

            return view('dashboard',[
                'start_state' => $start_state,
                'end_state' => $end_state,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'task_list' => $tasks,
            ]);
        }
        elseif (!$start_state && $end_state){
            //start karala | end karala naa
            $start_time = $attend[0]->start_time;

           //call to calculations class | method calculateEndTime
            $calculation = new Calculation();
            $end_time = $calculation->calculateEndTime($start_time);
            //end call to calculations class | method calculateEndTime


            //date convert to 12 hours
            $start_time = date('h:i:s A', strtotime($start_time));
            $end_time = date('h:i:s A', strtotime($end_time));

            return view('dashboard',[
                'start_state' => $start_state,
                'end_state' => $end_state,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'task_list' => $tasks,
            ]);
        }
        else{
            return view('dashboard',[
                'start_state' => $start_state,
                'end_state' => $end_state,
                'task_list' => $tasks,
            ]);
        }
    }

}
