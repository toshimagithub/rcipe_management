<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\Recipe;
use App\Models\User;
use App\Models\RecipesReview;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Recipe $recipe)
    {
        $user = auth()->user();

        // ログインユーザーが投稿したレシピを取得
        $recipes = Recipe::where('おすすめ', true)
        ->orderBy('created_at', 'desc')
        ->paginate(6);

        foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
        }

        // dd($recipes);

        return view('home', compact('recipes'));
    }


}
