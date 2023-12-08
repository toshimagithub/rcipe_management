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
    public function index(Recipe $recipe)
    {
        $user = auth()->user();

        $recipes = Recipe::with(['user'])->orderBy('created_at', 'desc')->paginate(6);

        foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
       //$recipe->averageStarは変数
       //$recipe->recipesreview->avg('star');ここの部分で星の平均を取得
      // viewの @if ($i <= $recipe->averageStar)は($i <=$recipe->recipesreview->avg('star'))これでも表示できる
        }

        // dd($recipes);
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
            'ingredients.*' => 'required|max:255',
            'descriptions.*' => 'required|max:255',
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
            'user_id' => $user->id, // ユーザーIDを明示的に設定
            'name'=>$request->name,
            'comment'=>$request->comment,
            'image'=>$name,
        ]);

        $ingredients = $request->input('ingredients');
        foreach ($ingredients as $ingredient) {
            $recipes->ingredients()->create(['ingredient' => $ingredient]);
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
    public function myrecipes(Recipe $recipe)
    {
        $user = auth()->user();

        // ログインユーザーが投稿したレシピを取得
        $recipes = Recipe::with(['user'])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(6);
        foreach ($recipes as $recipe) {
            $recipe->averageStar = $recipe->recipesreview->avg('star');
        }
        // 取得したレシピをビューに渡して表示
        return view('recipes.myrecipes', compact('recipes'));
        }


        public function edit( Recipe $recipe)
        {
            $ingredients = $recipe->ingredients;
            $steps = $recipe->steps;
            $recipesReview = RecipesReview::where('recipe_id', $recipe->id)
            ->where('user_id', auth()->user()->id)
            ->first(); // レビュー情報を取得 １件だけ返ってくる。

            return view('recipes.edit',compact('recipe','ingredients','steps', 'recipesReview'));

        }

        public function update(Request $request, Recipe $recipe)
        {

            // バリデーションルールの修正
            $this->validate($request, [
                'name' => 'required|max:255',
                'ingredients' => 'required|array',
                'descriptions' => 'required|array', // フォーム内の名前を修正
                'comment' => 'required|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024', // 必須ではなくなりました
            ]);
        
            // 画像の処理を修正
            if ($request->hasFile('image')) {
                $original = $request->file('image')->getClientOriginalName();
                $name = date('Ymd_His') . '_' . $original;
                $request->file('image')->move('storage/images', $name);
            } else {
                // 画像を変更しない場合は元の画像のファイル名を設定
                $name = $recipe->image;
            }
        
            // レシピ情報の更新
            $recipe->name = $request->name;
            $recipe->comment = $request->comment;
            $recipe->image = $name; // 画像の名前を保存
        
            $recipe->save();
        
            // 材料の更新
            $ingredients = $request->input('ingredients');
            if (is_array($ingredients)) {
                // 既存の材料を削除
                $recipe->ingredients()->delete();
        
                foreach ($ingredients as $ingredient) {
                    if (!empty($ingredient)) {
                        // 材料をレシピに紐づけて保存
                        $recipe->ingredients()->create(['ingredient' => $ingredient]);
                    }
                }
            }
        
            // 作り方の更新
            $descriptions = $request->input('descriptions');
            $order = 1; // 最初の順番
        
            if (is_array($descriptions)) {
                // 既存のステップを削除
                $recipe->steps()->delete();
        
                foreach ($descriptions as $description) {
                    if (!empty($description)) {
                        $recipe->steps()->create([
                            'description' => $description,
                            'order' => $order,
                        ]);
                        // 次の順番に進む
                        $order++;
                    }
                }
            }
        
            return redirect()->route('recipe.show', $recipe->id);
        }
        



            public function destroy(Recipe $recipe)
        {

            $recipe->ingredients()->delete();

            $recipe->delete();

            return redirect()->route('recipe.index');

        }

        public function rating(Recipe $recipe)
        {
            $user = auth()->user();
            $star = null;

            $recipes = $user->recipe()
                ->orderBy('created_at', 'desc')
                ->paginate(6);


            return view('recipes.rating', compact('recipes','star'));
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
                ->paginate(6);

            // レシピ一覧ページにリダイレクト
            return view('recipes.rating', compact('recipes', 'star'));
        }


    //     public function bestIndex(Request $request,Recipe $recipe)
    //     {
    //         $user = auth()->user();

    //           // ユーザーに関連するレシピを取得し、平均評価で並べ替えてページネーション
    //         $recipes = Recipe::with(['user'])->orderBy('created_at', 'desc')->paginate(6);

    // foreach($recipes as $recipe) {
    //     $recipe->averageStar = $recipe->recipesreview->avg('star');
    //     }
    //         return view('recipes.index', compact('recipes'));
    //     }

        public function bestIndex(Request $request)
        {
            $user = auth()->user();

            $recipes = Recipe::with(['user', 'recipesreview'])
            ->select('recipes.*') // 必要に応じて、適切なテーブル名を指定
            ->join('recipes_reviews', 'recipes.id', '=', 'recipes_reviews.recipe_id') // 正しい結合条件を指定
            ->groupBy('recipes.id') // グループ化することで AVG を正しく計算
            ->orderByRaw('AVG(recipes_reviews.star) DESC')
            ->orderByDesc('recipes.created_at') // テーブルエイリアスを使った場合、こちらも適切に修正
            ->paginate(6);

    foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
        }
            return view('recipes.index', compact('recipes'));
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
            ->paginate(6);


    foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
        }
            return view('recipes.index', compact('recipes'));
        }


        public function oldestIndex(Request $request)
        {
            $user = auth()->user();

        $recipes = Recipe::with(['user'])->orderBy('created_at', 'asc')->paginate(6);

        foreach($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');
        }

        // dd($recipes);
        return view('recipes.index', compact('recipes'));
    }

    public function ranking(Request $request)
{
    $user = auth()->user();

    $perPage = 6; // 1ページあたりのアイテム数

    // ページネーションのページ番号を取得
    $page = $request->query('page', 1);

    // ページごとにランキングデータを取得
    $recipes = Recipe::with(['user', 'recipesreview'])
        ->select('recipes.*')
        ->join('recipes_reviews', 'recipes.id', '=', 'recipes_reviews.recipe_id')
        ->groupBy('recipes.id')
        ->orderByRaw('AVG(recipes_reviews.star) DESC')
        ->orderByDesc('recipes.created_at')
        ->paginate($perPage); // ページネーションを行う

    // 順位を計算して $recipes に追加
    $rank = ($page - 1) * $perPage + 1; // ページごとに順位を計算し直すための基準となる値
    $prevStar = null; // 前のレシピの平均スター数を保持するための変数

    foreach ($recipes as $recipe) {
        $recipe->averageStar = $recipe->recipesreview->avg('star');

        if ($prevStar !== null && $recipe->averageStar < $prevStar) {
            $rank++;
        }

        $recipe->rank = $rank;
        $prevStar = $recipe->averageStar;
    }

    return view('recipes.ranking', compact('recipes'));
        }

        public function search(Request $request)
        {
            $keyword = $request->input('search');

            // dd($keyword);
                $recipes = Recipe::with(['user', 'ingredients', 'recipesreview'])
                    ->where(function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('id', 'like', '%' . $keyword . '%')
                            ->orWhere('comment', 'like', '%' . $keyword . '%')
                            ->orWhereHas('user', function ($userQuery) use ($keyword) {
                                $userQuery->where('name', 'like', '%' . $keyword . '%');
                            })
                            ->orWhereHas('ingredients', function ($ingredientsQuery) use ($keyword) {
                                $ingredientsQuery->where('ingredient', 'like', '%' . $keyword . '%');
                            });
                    })
                    ->orderBy('updated_at', 'desc')
                    ->paginate(6);


                foreach ($recipes as $recipe) {
                    $recipe->averageStar = $recipe->recipesreview->avg('star');
                }

                return view('recipes.search', compact('recipes', 'keyword'));
            }

            public function recommend(Recipe $recipe)
            {
                $user = auth()->user();
                // ログインユーザーが投稿したレシピを取得
                $recipes = Recipe::where('おすすめ', true)
                ->orderBy('created_at', 'desc')
                ->paginate(6);
                foreach($recipes as $recipe) {
                $recipe->averageStar = $recipe->recipesreview->avg('star');
                }
                return view('recipes.recommend', compact('recipes'));
            }





}
