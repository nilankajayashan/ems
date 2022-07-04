<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();


Route::get('/', function () {
    return view('attendance');
})->name('attend');

Route::get('dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

Route::get('profile', [\App\Http\Controllers\User\ProfileController::class, 'profile_data'])->name('profile');
Route::post('editprofile', [\App\Http\Controllers\User\ProfileController::class, 'edit_profile'])->name('edit_profile');

Route::get('leavetable', [\App\Http\Controllers\User\LeaveTableController::class, 'leave_table'])->name('leave_table');


Route::get('startworklogin',[\App\Http\Controllers\User\AttendanceController::class,'start_work_login'])->name('start_work_login');
Route::post('endwork',[\App\Http\Controllers\User\AttendanceController::class,'end_work'])->name('end_work');
Route::post('startworkguest',[\App\Http\Controllers\User\AttendanceController::class,'start_work_guest'])->name('start_work_guest');

Route::get('leave', [\App\Http\Controllers\User\LeaveHandleController::class, 'leave_details'])->name('leave');
Route::post('request_leave', [\App\Http\Controllers\User\LeaveHandleController::class, 'request_leave'])->name('request_leave');


Route::post('changepassword',[\App\Http\Controllers\User\PasswordResetController::class,'password_reset'])->name('password_reset');


Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//admin part
Route::get('admin_dashboard',[\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin_dashboard');
Route::get('filter_employee', [\App\Http\Controllers\Admin\EmployeeController::class, 'filter_employee'])->name('filter_employee');
Route::post('search_employee', [\App\Http\Controllers\Admin\EmployeeController::class, 'search_employee'])->name('search_employee');
Route::post('advance_filter', [\App\Http\Controllers\Admin\EmployeeController::class, 'advance_filter'])->name('advance_filter');


