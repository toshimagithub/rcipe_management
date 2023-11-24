@extends('adminlte::page')

@section('content_header')

@stop

@section('content')

@include('common.errors')   


<div class="container">
    <div class="row justify-content-center">
        <div class="mb-3 mx-auto">
            <div class="star-rating ">
                <form id="rating-form" action="{{ route('recipe.review', [$recipe->id]) }}" method="POST">
                    @csrf <!-- CSRFトークンを追加 -->
                    <div class="d-flex">
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="bi bi-star-fill star" data-rating="{{ $i }}" style="color: {{ $i <= (optional($recipesReview)->star ?? 0) ? '#FFD700' : '#c0c0c0' }}"></span>
                            @endfor
                        </div>
                        <div class="ms-3 rating-button-container">
                            <input type="hidden" id="selected-rating" name="selected-star" value="{{ optional($recipesReview)->star ?? 0 }}">
                            <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm">評価する</button>
                        </div>
                    </div>
                </form>
                <div id="rating-success-message" style="display: none;" class="alert alert-success mt-2">評価しました！</div>
            </div>
        </div>
    </div>

    <form action="{{ route('recipe.update', [$recipe->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <!-- レシピ名と画像 -->
            <div class="card col-md-6 text-center border-0 shadow-none bg-transparent">
                <div class="max-auto">
                    <input type="file" class="text-center" placeholder="写真" name="image">
                </div>
                <input type="text" name="name" class="form-control text-center" style="border: none; background-color: transparent; text-decoration: underline;" value="{{ old('name', $recipe->name) }}">
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

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@stop

@section('js')

<script>
    // 星評価のクリックイベントをリッスン
    const stars = document.querySelectorAll('.star');
    const ratingButton = document.getElementById('submit-rating');
    const selectedRating = document.getElementById('selected-rating');
    const ratingSuccessMessage = document.getElementById('rating-success-message');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            selectedRating.value = rating;
            updateStars(rating);
        });
    });

    // 評価ボタンをクリックしたときの処理
    ratingButton.addEventListener('click', () => {
        // 評価ボタンを無効化（再クリックを防ぐ）
        ratingButton.disabled = true;

        // フォームをサブミット
        document.getElementById('rating-form').submit();

        // 評価しましたのアラートを表示
        ratingSuccessMessage.style.display = 'block';

        // 3秒後にアラートを非表示にする
        setTimeout(() => {
            ratingSuccessMessage.style.display = 'none';
        }, 3000);
    });

    // 評価値に合わせて星を更新する関数
    function updateStars(rating) {
        stars.forEach(star => {
            const starRating = star.getAttribute('data-rating');
            if (starRating <= rating) {
                star.style.color = '#FFD700';
            } else {
                star.style.color = '#c0c0c0'; // フィルドされていない星の色
            }
        });

        document.getElementById('selected-rating').value = rating;
    }

    // 材料追加ボタンのクリックイベントをリッスン
    document.querySelector('.add-ingredient').addEventListener('click', function () {
        const container = document.querySelector('.ingredients-container');
        const newIngredientItem = document.createElement('div');
        newIngredientItem.className = 'd-flex align-items-center';

        const removeLink = document.createElement('a');
        removeLink.href = '#';
        removeLink.className = 'btn btn-xs btn-danger remove-step';
        removeLink.textContent = '削除';

        const newTextArea = document.createElement('input');
        newTextArea.name = 'ingredients[]'; // テキストエリアの名前
        newTextArea.className = 'text';
        newTextArea.style = 'border:none; background-color: transparent; text-decoration: underline; width: 300px; margin-left: 10px;';
        newTextArea.placeholder = '材料';

        newIngredientItem.appendChild(removeLink);
        newIngredientItem.appendChild(newTextArea);
        container.appendChild(newIngredientItem);
    });

    // 作り方追加ボタンのクリックイベントをリッスン
    document.querySelector('.add-step').addEventListener('click', function () {
        const container = document.querySelector('.steps-container');
        const newStepItem = document.createElement('div');
        newStepItem.className = 'd-flex';

        const removeLink = document.createElement('a');
        removeLink.href = '#';
        removeLink.className = 'btn btn-xs btn-danger remove-step';
        removeLink.textContent = '削除';
        removeLink.style.width = '34px';
        removeLink.style.height = '24px';
        removeLink.style.marginTop = '2px';

        const descriptionInput = document.createElement('input');
        descriptionInput.type = 'text';
        descriptionInput.name = 'descriptions[]';
        descriptionInput.className = 'text';
        descriptionInput.style = 'border:none; background-color: transparent; text-decoration: underline; width: 300px; margin-left: 10px;';
        descriptionInput.placeholder = '作り方';

        newStepItem.appendChild(removeLink);
        newStepItem.appendChild(descriptionInput);
        container.appendChild(newStepItem);
    });

    // 削除リンクのクリックイベントをリッスン
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-ingredient') || event.target.classList.contains('remove-step')) {
            const item = event.target.closest('.d-flex');
            if (item) {
                item.remove();
            }
        }
    });
</script>

@stop
