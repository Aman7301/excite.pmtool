<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    
    Route::get('/AllEmployee',[EmployeeController::class,'AllEmp']);
    
    //Employee
    Route::prefix('employee')->group(function () {
        Route::put('/update', [EmployeeController::class, 'UpdateEmployee']);
        Route::get('/{id}', [EmployeeController::class, 'GetEmployee']);

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

    //TimeSheet
      Route::Post('Time/create',[TimeController::class,'AddTime']);
      Route::Post('Time/History/{id}',[TimeController::class,'GetTimeHistory']);
      Route::get('Time/{id}',[TimeController::class,'GetTimeByEmp']);
      Route::put('Time/update',[TimeController::class,'updateTime']);

      //Holiday 
      Route::post('Add/Holiday',[TimeController::class,'AddHoliday']);
      Route::post('get/Holiday',[TimeController::class,'getHoliday']);

      //Employee Leave
      Route::post('Add/Leave',[LeaveController::class,'AddLeave']);
      Route::post('Get/LeaveType',[LeaveController::class,'GetLeaveType']);
      Route::get('Get/Leave/{id}',[LeaveController::class,'GetLeaveByEmp']);
      Route::delete('delete/Leave/{id}',[LeaveController::class,'deleteLeave']);
      Route::put('Edit/Leave',[LeaveController::class,'updateLeave']);

      //Dashboard Api
      Route::get('Get/Dashboard/{id}',[DashboardController::class,'GetDasboardData']);
      Route::get('Get/Calender/Dashboard/{id}',[DashboardController::class,'GetCalenderDasboard']);
      Route::get('Get/TimeSheet/Dashboard/{id}',[DashboardController::class,'GetTimeSheetDasboard']);

      //Location 
      Route::post('Add/Location',[DashboardController::class,'AddLocation']);
      Route::get('Get/Location',[DashboardController::class,'GetLocation']);

      //Project
      Route::post('Add/Project',[TimeController::class,'AddProject']);
      Route::get('Get/Project',[TimeController::class,'GetProject']);
      Route::put('Update/Project',[TimeController::class,'UpdateProject']);
      Route::delete('Delete/Project/{id}',[TimeController::class,'DeleteProject']);

      //Task
      Route::post('Add/Task',[TimeController::class,'AddTask']);
      Route::get('Get/Task',[TimeController::class,'GetTask']);
      Route::put('Update/Task',[TimeController::class,'UpdateTask']);
      Route::delete('Delete/Task/{id}',[TimeController::class,'DeleteTask']);

      //Invoice
      Route::post('Make/Invoice',[InvoiceController::class,'MakeInvoice']);
      Route::post('Get/Invoice',[InvoiceController::class,'GetInvoice']);

      //Company
      Route::post('Add/Company',[InvoiceController::class,'AddCompany']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});