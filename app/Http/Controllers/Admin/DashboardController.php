<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $result = DB::select('SELECT COUNT(user_id) AS count, division FROM users GROUP BY division ORDER BY division ASC');
        return view('dashboard',[
            'divisions_user_count' => $result,
        ]);
    }
}
