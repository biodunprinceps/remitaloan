<?php

use App\Services\RemitaService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RemitaController;

Route::get('/', function () {
    return view('welcome');
});

Route::withoutMiddleware('web')->prefix('api')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'createAdmin']);
    });


    Route::prefix('loan')->group(function () {
        Route::post('apply', [LoanController::class, 'newApplication']);
        Route::post('viewOneLoan', [LoanController::class, 'viewOneLoan']);
        Route::post('listLoans', [LoanController::class, 'listLoans']);
        Route::post('changeStatus', [LoanController::class, 'changeStatus']);
        Route::post('loanCalculator', [LoanController::class, 'loanCalculator']);
    });


    Route::prefix('remita')->group(function () {
        Route::post('accountDetails', [RemitaController::class, 'checkRemitaDataReferencingAccountDetails']);
        Route::post('telephone', [RemitaController::class, 'checkRemitaDataReferencingTelephone']);
    });


    
    
    Route::post('setupDeduction', [RemitaController::class, 'setupDeduction']);
});