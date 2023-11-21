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
    Route::post('/review/{recipe}', [App\Http\Controllers\RecipeController::class, 'review'])->name('recipe.review');
    Route::get('/myrecipes', [App\Http\Controllers\RecipeController::class, 'myrecipes'])->name('recipe.myrecipes');
    Route::get('/edit/{recipe}', [App\Http\Controllers\RecipeController::class, 'edit'])->name('recipe.edit');
    Route::patch('/update/{recipe}', [App\Http\Controllers\RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/destroy/{recipe}', [App\Http\Controllers\RecipeController::class, 'destroy'])->name('recipe.destroy');
});



