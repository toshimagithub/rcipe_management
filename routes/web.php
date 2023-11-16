<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('recipes')->group(function () {
    Route::get('/', [App\Http\Controllers\RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/create', [App\Http\Controllers\RecipeController::class, 'create'])->name('recipe.create');
    Route::post('/store', [App\Http\Controllers\RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/show/{recipe}', [App\Http\Controllers\RecipeController::class, 'show'])->name('recipe.show');
});



