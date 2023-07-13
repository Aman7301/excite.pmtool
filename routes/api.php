<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Emp Register and Login
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    
    
    //Employee
    Route::prefix('employee')->group(function () {
        Route::put('/update', [EmployeeController::class, 'UpdateEmployee']);
        Route::get('/{id}', [EmployeeController::class, 'GetEmployee']);
        Route::get('/All', [EmployeeController::class, 'AllEmployee']);

        //Employee Academy detail
        Route::post('academy/register', [EmployeeController::class, 'CreateAcademy']);
        Route::delete('academy/delete/{id}', [EmployeeController::class, 'deleteAcademy']);
        Route::put('academy/update', [EmployeeController::class, 'updateAcademy']);

        //Employee professional detail
        Route::post('professional/register', [EmployeeController::class, 'Createprofessional']);
        Route::delete('professional/delete/{id}', [EmployeeController::class, 'deleteprofessional']);
        Route::put('professional/update', [EmployeeController::class, 'updateprofessional']);

        //Employee Documents detail
        Route::post('Document/register', [EmployeeController::class, 'CreateDocument']);
        Route::delete('Document/delete/{id}', [EmployeeController::class, 'deleteDocument']);
        Route::put('Document/update', [EmployeeController::class, 'updateDocument']);

        //Employee Project details
        Route::post('Project/register', [EmployeeController::class, 'CreateProject']);
        Route::delete('Project/delete/{id}', [EmployeeController::class, 'deleteProject']);
        Route::put('Project/update', [EmployeeController::class, 'updateProject']);
    });

    //Time 
      Route::Post('Time/create',[TimeController::class,'AddTime']);
      Route::Post('Time/{id}',[TimeController::class,'GetTime']);

      //Holiday 
      Route::post('Add/Holiday',[TimeController::class,'AddHoliday']);
      Route::post('get/Holiday',[TimeController::class,'getHoliday']);

      //Employee Leave
      Route::post('Add/Leave',[LeaveController::class,'AddLeave']);
      Route::post('Get/LeaveType',[LeaveController::class,'GetLeaveType']);
      Route::get('Get/Leave/{id}',[LeaveController::class,'GetLeaveByEmp']);
      Route::delete('delete/Leave/{id}',[LeaveController::class,'deleteLeave']);
      Route::put('Edit/Leave',[LeaveController::class,'updateLeave']);

      //Total Leave Changes
    //   Route::post('')

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});