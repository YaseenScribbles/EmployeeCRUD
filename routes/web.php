<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $employees = Employee::paginate(10);
    return view('Employees.list',compact('employees'));
});

Route::resource('employee',EmployeeController::class);
Route::get('/employees/export',[EmployeeController::class,'export'])->name('employees.export');
Route::post('/employees/import',[EmployeeController::class,'import'])->name('employees.import');
Route::get('/download-sample-file', [EmployeeController::class,'sample'])->name('download.sample');
Route::get('/employees',[EmployeeController::class,'search'])->name('employees.search');

