<?php

declare(strict_types=1);

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/properties', [PropertyController::class, '__invoke']);
});

