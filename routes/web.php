<?php

use App\Http\Controllers\ConverterController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
    // return view('welcome');
});

Route::get('/export/converter/{converter}/{template}', [ConverterController::class, 'exportExcel'])->name('export.converter');

Route::get('/export/order/{template}', [OrderController::class, 'exportExcel'])->name('export.orders');
