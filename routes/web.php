<?php

use App\Services\RemitaService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemitaController;

Route::get('/', function () {
    return view('welcome');
});

Route::withoutMiddleware('web')->middleware('api')->prefix('api/remita')->group(function () {
    Route::post('checkRemitaDataReferencingAccountDetails', [RemitaController::class, 'checkRemitaDataReferencingAccountDetails']);
    Route::post('checkRemitaDataReferencingTelephone', [RemitaController::class, 'checkRemitaDataReferencingTelephone']);
    Route::post('setupDeduction', [RemitaController::class, 'setupDeduction']);
});