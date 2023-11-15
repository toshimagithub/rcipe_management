<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Ingredient;

use App\Models\Recipe;
use App\Models\user;

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

    return redirect('/recipes');
}


}
