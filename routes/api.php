<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\revenue\AdminRevenueController;
use Illuminate\Support\Facades\Route;



Route::get('getRevenueData', [AdminRevenueController::class, 'getRevenueData'])->name('api.getRevenueData');
