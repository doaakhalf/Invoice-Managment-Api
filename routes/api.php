<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    ///POST api/contracts/{id}/invoices 
Route::post('/contracts/{contract}/invoices', [InvoiceController::class, 'store']);

///GET api/contracts/{id}/invoices
Route::get('/contracts/{contract}/invoices', [InvoiceController::class, 'index']);


///GET /api/invoices/{id}
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);

/// POST api/invoices/{id}/payments
Route::post('/invoices/{invoice}/payments', [InvoiceController::class, 'RecordPayment']);

/// GET api/contracts/{id}/summary
Route::get('/contracts/{contract}/summary', [InvoiceController::class, 'getContractSummary']);

});
