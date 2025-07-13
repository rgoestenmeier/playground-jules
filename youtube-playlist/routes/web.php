<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;

Route::get('/', [PlaylistController::class, 'show']);
