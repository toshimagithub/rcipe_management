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

Route::prefix('recipes')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/create', [App\Http\Controllers\RecipeController::class, 'create'])->name('recipe.create');
    Route::post('/store', [App\Http\Controllers\RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/show/{recipe}', [App\Http\Controllers\RecipeController::class, 'show'])->name('recipe.show');
    Route::post('/review/{recipe}', [App\Http\Controllers\RecipeController::class, 'review'])->name('recipe.review');
    Route::get('/myrecipes', [App\Http\Controllers\RecipeController::class, 'myrecipes'])->name('recipe.myrecipes');
    Route::get('/edit/{recipe}', [App\Http\Controllers\RecipeController::class, 'edit'])->name('recipe.edit');
    Route::patch('/update/{recipe}', [App\Http\Controllers\RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/destroy/{recipe}', [App\Http\Controllers\RecipeController::class, 'destroy'])->name('recipe.destroy');
    Route::get('/rating', [App\Http\Controllers\RecipeController::class, 'rating'])->name('recipe.rating');
    Route::get('/sortRating', [App\Http\Controllers\RecipeController::class, 'sortRating'])->name('recipe.sortRating');
    Route::get('/best/index', [App\Http\Controllers\RecipeController::class, 'bestIndex'])->name('recipe.bestIndex');
    Route::get('/worst/index', [App\Http\Controllers\RecipeController::class, 'worstIndex'])->name('recipe.worstIndex');
    Route::get('/oldest/index', [App\Http\Controllers\RecipeController::class, 'oldestIndex'])->name('recipe.oldestIndex');
    Route::get('/ranking', [App\Http\Controllers\RecipeController::class, 'ranking'])->name('recipe.ranking');
    Route::get('/search', [App\Http\Controllers\RecipeController::class, 'search'])->name('recipe.search');
    Route::get('/recommend', [App\Http\Controllers\RecipeController::class, 'recommend'])->name('recipe.recommend');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::patch('/recommend/{recipe}', [App\Http\Controllers\AdminController::class, 'recommend'])->name('admin.recommend');
    Route::patch('/unRecommend/{recipe}', [App\Http\Controllers\AdminController::class, 'unRecommend'])->name('admin.unRecommend');
    Route::get('/management', [App\Http\Controllers\AdminController::class, 'management'])->name('admin.management');
    Route::patch('/grant/{user}', [App\Http\Controllers\AdminController::class, 'grant'])->name('admin.grant');
    Route::patch('/revoke/{user}', [App\Http\Controllers\AdminController::class, 'revoke'])->name('admin.revoke');
    Route::patch('/revoke/{user}', [App\Http\Controllers\AdminController::class, 'revoke'])->name('admin.revoke');
    Route::delete('/destroy/{recipe}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
    Route::delete('/UserDestroy/{user}', [App\Http\Controllers\AdminController::class, 'UserDestroy'])->name('user.destroy');
});


Route::get('pdf/{recipe}',[App\Http\Controllers\PDFController::class, 'index'])->name('pdf');






