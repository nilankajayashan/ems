<?php

namespace App\Http\Controllers\User;

use App\Classes\Calculation;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use function redirect;

class AttendanceController extends Controller
{
    public function start_work_login(){
        try {

            $start_time = date('H:i:s');

            //call to calculations class | method calculateEndTime
            $calculation = new Calculation();
            $end_time = $calculation->calculateEndTime($start_time);
            //end call to calculations class | method calculateEndTime

            DB::table('attendances')->insert([
                'user_id' => Auth::user()->user_id,
                'work_date' => date('Y-m-d'),
                'start_time' => $start_time
            ]);

            $start_time = date('h:i:s a', strtotime($start_time));
            $end_time = date('h:i:s a', strtotime($end_time));

            return redirect()->route('dashboard',[
                'state'=>'dashboard',
                'start_time' => $start_time,
                'end_time' => $end_time,
            ])->with([
                'state' => true,
                'message' => 'Start success...!',
            ]);
        }
        catch (Throwable $e){
            return redirect()->route('dashboard',['state'=>'dashboard'])->with(['state' => false, 'message' => 'Please try again later...!']);
        }
    }

    public function end_work(Request $req){
        $result = str_replace("\n", ",", $req->input('tasks'));
        $result = str_replace("\r", "", $result);
        $result = str_replace("\"", "'", $result);
        $result = str_replace(";", ",", $result);

        try
        {
            $work_date = date('Y-m-d');
            $end_time = date('H:i:s');
            DB::table('attendances')
                ->where('user_id', Auth::user()->user_id)
                ->where('work_date',$work_date)
                ->update([
                    'end_time' => $end_time,
                    'work_description' => $result,
                    ]);
            return redirect()->route('dashboard',[
                'state'=>'dashboard'
            ])->with([
                'state' => true,
                'message' => 'End success...!',
            ]);
        }
        catch (Throwable $e)
        {
            return redirect()->route('dashboard',['state'=>'dashboard'])->with(['state' => false, 'message' => 'Please try again later to end...!']);
        }
    }

    public function start_work_guest(Request $request){

        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $user = User::where('user_id', '=', $request->input('user_id'))->first();
        if ($user === null){
            return redirect()->route('attend')
                ->withErrors(
                    [
                        'user_id' => 'Dear Employee, you entered id have not in EMS...!',
                    ]);
        }else{
            try {
                $date = date('Y-m-d');
                $attend = DB::select('select * from attendances where user_id = ? and work_date = ?' , [$request->input('user_id'),$date]);
                $time = date('H:i:s');
                if(count($attend) == 0)
                {
                    DB::table('attendances')->insert([
                        'user_id' => $request->input('user_id'),
                        'work_date' => $date,
                        'start_time' => $time
                    ]);
                    return redirect()->route('attend')->with([
                        'state' => true,
                        'message' => 'Start success...!',
                    ]);
                }elseif ($attend[0]->end_time == null)
                {
                    DB::table('attendances')
                        ->where('user_id', $request->input('user_id'))
                        ->where('work_date',$date)
                        ->update([
                            'end_time' => $time,
                        ]);
                    return redirect()->route('attend')->with([
                        'state' => true,
                        'message' => 'End success...!',
                    ]);
                }
                else{
                    return redirect()->route('attend')->with([
                        'state' => false,
                        'message' => 'Try again tomorrow...!',
                    ]);
                }
            }
            catch (Throwable $e){
                return redirect()->route('attend')->with(['state' => false, 'message' => 'Please try again later...!']);
            }
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
