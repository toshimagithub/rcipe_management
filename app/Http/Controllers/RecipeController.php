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


class RecipeController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        $recipes = Recipe::with(['user','ingredients'])->orderBy('updated_at', 'desc')->get();


        return view('recipes.index', compact('recipes'));

    }
 
    public function create()
    {
        return view('recipes.create');
    }


    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|max:255',
            'ingredients'=>'required',
            'descriptions'=>'required',
            'comment'=>'required|max:255',
            'image'=>'image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $user = auth()->user();

        $name = null;

        if($request->hasFile('image')){
            $original = $request->file('image')->getClientOriginalName();
            $name = date('Ymd_His'). '_' .$original;
            $request->file('image')->move('storage/images',$name);
        }

        $recipes = $user->recipes()->create([
            'name'=>$request->name,
            'comment'=>$request->comment,
            'image'=>$name,
        ]);


    $ingredients = $request->input('ingredients');
    foreach($ingredients as $ingredient ){
        $recipes->ingredients()->create(['ingredient'=>$ingredient]);
    }

    $descriptions = $request->input('descriptions');
    $order = 1; // 最初の順番

    foreach ($descriptions as $description) {
        $recipes->steps()->create([
            'description' => $description,
            'order' => $order,
        ]);
        // 次の順番に進む
        $order++;
    }


    return redirect()->route('recipe.index');
}

public function show(Recipe $recipe)
{
    $ingredients = $recipe->ingredients;
    $steps = $recipe->steps;
    $recipesReview = RecipesReview::where('recipe_id', $recipe->id)
    ->where('user_id', auth()->user()->id)
    ->first(); // レビュー情報を取得 １件だけ返ってくる。



    return view('recipes.show',compact('recipe','ingredients','steps', 'recipesReview'));

}

public function review(Request $request, Recipe $recipe)
{


    $request->validate([
        'selected-star' => 'required|integer|min:1|max:5',
    ]);


    $user = auth()->user();
    $recipesReview = RecipesReview::where('user_id', $user->id)->where('recipe_id', $recipe->id)->first();

    if ($recipesReview) {
        // ユーザーがすでに評価を行っている場合、評価を更新
        $recipesReview->star = $request->input('selected-star');
        $recipesReview->save();
    } else {
        // 評価がない場合、新しい評価を作成
        $recipesReview = new RecipesReview();
        $recipesReview->recipe_id = $recipe->id;
        $recipesReview->star = $request->input('selected-star');
        $recipesReview->user_id = $user->id;
        $recipesReview->save();
    }




    return redirect()->route('recipe.show', $recipe->id);

}


}
