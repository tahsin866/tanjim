<?php

// Ensure Composer's autoloader is included if running standalone scripts
// require __DIR__.'/../vendor/autoload.php';


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardApplicationController;
use App\Http\Controllers\Admin\DashboardController;
// Marhala Controller Routes


// Stats API for live user info
Route::get('api/stats', [App\Http\Controllers\StatsController::class, 'getStats']);
