<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;


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

Route::group(['prefix' => 'v1'], function () {

    Route::post('/admin/login', [AuthController::class,'login']);
    
    //COMPANY
    Route::resource('/company', CompanyController::class);
    Route::post('/company/upload-logo', [CompanyController::class,"uploadLogo"]);
    
    //EMPLOYEE
    Route::resource('/employee', EmployeeController::class);
    Route::post('/employee/upload-picture', [EmployeeController::class,"uploadPicture"]);
    
});

