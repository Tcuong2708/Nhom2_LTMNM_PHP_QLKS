<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Staff\CheckinController;
use App\Http\Controllers\Api\Staff\CheckoutController;
use App\Http\Controllers\Api\Staff\InvoiceController;
use App\Http\Controllers\Api\Staff\RoomMapController;

// API Sơ đồ phòng
Route::get('/rooms/map', [RoomMapController::class, 'index']);

// API Check-in
Route::get('/checkin/init', [CheckinController::class, 'getPendingCheckins']);
Route::post('/checkin/execute/{id}', [CheckinController::class, 'executeCheckin']);
Route::get('/checkin/search', [CheckinController::class, 'search']);

// API Check-out
Route::get('/checkout/invoices', [CheckoutController::class, 'getActiveInvoices']);
Route::post('/checkout/execute', [CheckoutController::class, 'executeCheckout']);

// API Hóa đơn
Route::get('/invoices', [InvoiceController::class, 'index']);
Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
