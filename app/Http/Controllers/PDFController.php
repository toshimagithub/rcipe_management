<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\Recipe;
use App\Models\User;
use App\Models\RecipesReview;

use PDF;

class PDFController extends Controller
{
    // public function index(){

    //     $pdf = PDF::loadView('hello');

    //     return $pdf->download('hello.pdf');
    // }


    public function index(Request $request, Recipe $recipe)
    {
        $ingredients = $recipe->ingredients;
        $steps = $recipe->steps;
        $recipesReview = $recipe->averageStar();
        $pdf = PDF::loadView('hello', compact('recipe', 'ingredients', 'steps', 'recipesReview'));

        return $pdf->download('hello.pdf');
    }
}


