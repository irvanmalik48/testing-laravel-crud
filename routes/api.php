<?php

use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;

Route::apiResource('pasien', PasienController::class);