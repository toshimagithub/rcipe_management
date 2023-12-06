<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PDF</title>
<style>
@font-face{
    font-family: ipag;
    font-style: normal;
    font-weight: normal;
    src:url('{{ storage_path('fonts/ipag.ttf')}}');
}
@font-face{
    font-family: ipag;
    font-style: bold;
    font-weight: bold;
    src:url('{{ storage_path('fonts/ipag.ttf')}}');
}
body {
font-family: ipag;
}
</style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
        <div class="mb-3 mx-auto">
            <div class="star-rating ">
                    <div class="d-flex">
                      <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $recipesReview)
                                <span class="bi bi-star-fill" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                            @else
                                @if ($i - 0.5 <= $recipesReview)
                                    <span class="bi bi-star-half" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                                @else
                                    <span class="bi bi-star" data-rating="{{ $i }}" style="color: #c0c0c0;"></span>
                                @endif
                            @endif
                        @endfor
                    </div>
                        <div class="ms-3 rating-button-container">
                            <input type="hidden" id="selected-rating" name="selected-star" value="{{ optional($recipesReview)->star ?? 0 }}">
                            <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm">評価する</button>
                        </div>
                    </div>
                <div id="rating-success-message" style="display: none;" class="alert alert-success mt-2">評価しました！</div>
            </div>
        </div>
    </div>

    <form action="{{ route('pdf', [$recipe->id]) }}" method="get" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <!-- レシピ名と画像 -->
            <div class="card col-md-6 text-center border-0 shadow-none bg-transparent">
                <div class="max-auto">
                    <input type="file" class="text-center" placeholder="写真" name="image">
                </div>
                <input type="text" name="name" class="form-control text-center " style="border: none; background-color: transparent; text-decoration: underline; font-weight: bold;" value="{{ old('name', $recipe->name) }}">
                @if($recipe->image)
                    <img src="{{ asset('storage/images/'.$recipe->image) }}" class="rounded" style="height:auto; width:auto;" name="image">
                @endif
                <div class="text-sm font-semibold flex flex-row-reverse mb-1">
                    <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                </div>
                <label>コメント</label>
                <textarea class="w-auto py-1 border border-gray-300 rounded-md font-semibold whitespace-pre-line" name="comment" cols="60" rows="3" style="resize: none; border-radius: 10px;">{{ old('comment', $recipe->comment) }}</textarea>
                <div>
                    <button type="submit" class="mt-2 btn btn-warning">更新する</button>
                </div>
            </div>

            <!-- 材料 -->
            <div class="card col-md-6 border-0 shadow-none bg-transparent mt-5">
                <div>
                    <label>材料</label>
                </div>
                <div class="ingredients-container">
                    <button type="button" class="btn btn-sm btn-primary add-ingredient">＋</button>
                    @foreach($ingredients as $ingredient)
                        <div class="d-flex align-items-center">
                            <div>
                                <a href="#" class="btn btn-xs btn-danger remove-ingredient">削除</a>
                            </div>
                            <div style="margin-left: 10px; text-decoration: underline; flex-grow: 1;">
                                <input type="text" name="ingredients[]" style="border:none; background-color: transparent; text-decoration: underline; width: 100%;" value="{{ old('ingredients.' . $loop->index, $ingredient->ingredient) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
     
                <br>
                <!-- 作り方 -->
                <div>
                    <label>作り方</label>
                </div>
                <div class="steps-container">
                    <button type="button" class="btn btn-sm btn-primary add-step">＋</button>
                    @foreach($steps as $step)
                        <div class="d-flex">
                            <div class="">
                                <a href="#" class="btn btn-xs btn-danger remove-step">削除</a>
                            </div>
                            <div class="me-3" style="text-decoration: underline;">
                                <input type="text" name="descriptions[]" style="margin-left: 10px; border:none; background-color: transparent; text-decoration: underline; width: 300px;" value="{{ old('descriptions.' . $loop->index, $step->description) }}" placeholder="作り方">
                                <br>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="card col-md-6 text-center border-0 shadow-none bg-transparent">
            <form action="{{ route('recipe.destroy', $recipe->id) }}" method="post" onsubmit="return confirm('本当に削除しますか？')">
                @csrf
                @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width:90px;">削除</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>