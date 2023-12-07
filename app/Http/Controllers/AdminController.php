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



class AdminController extends Controller
{
    public function index(Recipe $recipe)
    {
        $recipes = Recipe::with(['user'])->orderBy('created_at', 'desc')->paginate(6);
        foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
        }
        return view('admin.index', compact('recipes'));
    }

    public function recommend(Recipe $recipe)
    {
        $recipe->update(['おすすめ' => true]);
        // $recipe->update(['おすすめ' => 1]);  これでも可

        return redirect()->back()->with('success', 'おすすめに変更しました。');
    }
    public function unRecommend(Recipe $recipe)
    {
        $recipe->update(['おすすめ' => false]);
        // $recipe->update(['おすすめ' => 0]);  これでも可
        return redirect()->back()->with('success', 'おすすめを解除しました。');
    }

    public function management(User $user)
{
    // すべてのユーザーを取得
    $users = User::all();
    // 各ユーザーが投稿したレシピの数を取得
    $userRecipesCount = [];

    return view('admin.grant', compact('users'));
}


    public function grant(User $user)
    {
        $user->update(['role' => "管理者"]);

        return redirect()->back()->with('success', '管理者に変更しました。');
    }
    public function revoke(User $user)
    {
        $user->update(['role' => "ユーザー"]);

        return redirect()->back()->with('success', 'ユーザーに戻しました。');
    }


}
