<?php

use App\Http\Controllers\Api\ArticlesController;
use Illuminate\Support\Facades\Route;

Route::get('articles', [ArticlesController::class, 'index']);
Route::get('articles/{article:slug}', [ArticlesController::class, 'show']);
