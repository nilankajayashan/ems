<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function filter_employee(){
        $users = DB::select('select user_id as  `User ID`, first_name as  `First Name`, last_name as `Last Name` from users order by user_id asc');
        $keys = $this->get_keys($users[0]);
        $divisions = $this->divisions();
        return view('dashboard',['divisions' => $divisions, 'tbl_header' => $keys],compact('users'));

    }
    public function search_employee(Request $request){
        $users = DB::select("select user_id, first_name, last_name from users where first_name like '%$request->search%' or last_name like '%$request->search%'");
        if($users != null){
            $keys = $this->get_keys($users[0]);
        }else{
            $keys = null;
        }
        $divisions = $this->divisions();
        return view('dashboard',['divisions' => $divisions, 'tbl_header' => $keys],compact('users'));
    }

    public function divisions(){
        $division = User::select('division')->distinct()->get();
        return $division;
    }
    public function get_keys($user){
        $keys = [];
        $vars = get_object_vars($user);
        foreach($vars as $key=>$value) {
            $keys[] = $key;
        }
        return $keys;
    }
     public function advance_filter(Request $request){
        $users = DB::select($request->sql);
        $keys = $this->get_keys($users[0]);
         $divisions = $this->divisions();
         return view('dashboard',['divisions' => $divisions, 'tbl_header' => $keys],compact('users'));
       // dd($request->sql);
     }
}
