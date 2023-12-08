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

    public function index($recipeId)
    {
        // レシピを取得
        $recipe = Recipe::find($recipeId);
        $ingredients = $recipe->ingredients;
        $steps = $recipe->steps;

        // PDFに表示するデータやビューを設定
        $data = [
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'steps' => $steps,
        ];

        // PDFを生成
        $pdf = PDF::loadView('hello', $data);

        // PDFをダウンロードまたは表示
        return $pdf->download('hello.pdf');
    }



        // public function generatePDF($recipeId)
        // {
        //     // レシピを取得
        //     $recipe = Recipe::find($recipeId);
        //     // PDFに表示するデータやビューを設定
        //     $data = [
        //         'recipe' => $recipe,
        //     ];

        //     // PDFを生成
        //     $pdf = PDF::loadView('pdf.recipe', $data);

        //     // 例: publicディレクトリ内のpdfディレクトリに保存する場合
        //     $pdf->save(public_path('pdf/recipe.pdf'));

        //     // PDFをダウンロードまたは表示
        //     return $pdf->download('recipe.pdf');
        // }

}


