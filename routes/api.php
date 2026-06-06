<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ItemapiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Organized, clean, and well-structured API routes.
| Public routes are open; protected routes require sanctum auth.
|
*/

// -----------------------------
// Public Routes
// -----------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Language & index (publicly accessible)
Route::get('/index', [AuthController::class, 'index']);
Route::get('/lang/{locale}', [AuthController::class, 'lang']);

// Items (public access for listing, categories, and single item)
Route::get('/items', [ItemapiController::class, 'index']);
Route::get('/items/categories', [ItemapiController::class, 'categories']);
Route::get('/items/{id}', [ItemapiController::class, 'show']);
Route::get('/total-categories', [ItemapiController::class, 'getTotalCategories']);

// -----------------------------
// Protected Routes (auth:sanctum)
// -----------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);


    // Profile
    Route::post('/profile/update/{id}', [AuthController::class, 'updateProfile']);
    Route::post('/profile/update-password/{id}', [AuthController::class, 'updatePassword']);

    // Items - protected actions
    Route::post('/items/store', [ItemapiController::class, 'store']);
    Route::post('/items/delete-selected', [ItemapiController::class, 'deleteSelected']);
    Route::post('/items/import', [ItemapiController::class, 'import']);
    Route::post('/items/export', [ItemapiController::class, 'export']);
});
