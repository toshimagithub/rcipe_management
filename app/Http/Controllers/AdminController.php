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
        $recipes = Recipe::with(['user'])->orderBy('created_at', 'desc')->paginate(12);
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

    public function destroy(Recipe $recipe)
    {
        $recipe->ingredients()->delete();
        $recipe->delete();
        return redirect()->route('admin.index')->with('success', '削除しました。');
    }

    public function UserDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.management')->with('success', '削除しました。');
    }

    public function sortRating(Request $request)
    {
        // 認証済みユーザーを取得
        $user = auth()->user();
        // フォームから評価を取得
        $star = $request->input('star');

        // ユーザーが評価したレシピを取得
        $recipes = $user->recipe()
            ->wherePivot('star', $star) // 中間テーブルの star カラムで絞り込む
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // レシピ一覧ページにリダイレクト
        return view('recipes.rating', compact('recipes', 'star'));
    }

    public function bestIndex(Request $request)
    {
        $user = auth()->user();

        $recipes = Recipe::with(['user', 'recipesreview'])
        ->select('recipes.*') // 必要に応じて、適切なテーブル名を指定
        ->join('recipes_reviews', 'recipes.id', '=', 'recipes_reviews.recipe_id') // 正しい結合条件を指定
        ->groupBy('recipes.id') // グループ化することで AVG を正しく計算
        ->orderByRaw('AVG(recipes_reviews.star) DESC')
        ->orderByDesc('recipes.created_at') // テーブルエイリアスを使った場合、こちらも適切に修正
        ->paginate(12);

        foreach($recipes as $recipe) {
            $recipe->averageStar = $recipe->recipesreview->avg('star');
            }
        return view('admin.index', compact('recipes'));
    }

    public function worstIndex(Request $request)
    {
        $user = auth()->user();

        $recipes = Recipe::with(['user', 'recipesreview'])
        ->select('recipes.*') // 必要に応じて、適切なテーブル名を指定
        ->join('recipes_reviews', 'recipes.id', '=', 'recipes_reviews.recipe_id') // 正しい結合条件を指定
        ->groupBy('recipes.id') // グループ化することで AVG を正しく計算
        ->orderByRaw('AVG(recipes_reviews.star) asc')
        ->orderByDesc('recipes.created_at') // テーブルエイリアスを使った場合、こちらも適切に修正
        ->paginate(12);


        foreach($recipes as $recipe) {
            $recipe->averageStar = $recipe->recipesreview->avg('star');
            }
        return view('admin.index', compact('recipes'));
    }


    public function oldestIndex(Request $request)
    {
        $user = auth()->user();

    $recipes = Recipe::with(['user'])->orderBy('created_at', 'asc')->paginate(12);

    foreach($recipes as $recipe) {
    $recipe->averageStar = $recipe->recipesreview->avg('star');
    }

    return view('admin.index', compact('recipes'));
}

}
