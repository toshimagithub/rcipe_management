
@extends('adminlte::page')

@section('title', 'Edit')

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
            <div class="card col-sm-6 col-md-6    text-center border-0 shadow-none bg-transparent">
                <div class="max-auto">
                    <input type="file" class="text-center" placeholder="写真" name="image">
                </div>
                <input type="text" name="name" class="form-control text-center @error('name') is-invalid @enderror " style="border: none;  font-weight: bold;" value="{{ old('name', $recipe->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if($recipe->image)
                    <img src="{{ asset('storage/images/'.$recipe->image) }}" class="rounded" style="height:auto; width:auto;" name="image">
                @endif
                <div class="text-sm font-semibold flex flex-row-reverse mb-1">
                    <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                </div>
                <label>コメント</label>

                <textarea class="w-auto py-1 border border-gray-300 rounded-md font-semibold whitespace-pre-line
                @error('comment') is-invalid @enderror"
                name="comment" cols="60" rows="3" style="resize: none; border-radius: 10px; height: 100px;">{{ old('comment', $recipe->comment) }}</textarea>
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 材料 -->
            <div class="card col-sm-6 col-md-6  border-0 shadow-none bg-transparent ">
                <div class="form-group">
                    <label for="exampleFormControlInput1">材料</label>
                    <br>
                    <button type="button" class="my-1 btn btn-sm btn-primary add-ingredient">＋</button>
                    <br>
                    <div class="ingredients-container">
                        @php
                            $oldIngredients = old('ingredients', $ingredients->pluck('ingredient')->toArray());
                            $count = count($oldIngredients);
                        @endphp
                        @if($count > 0)
                            @for($i = 0; $i < $count; $i++)
                                <div class="mb-2 ingredient-item">
                                    <input type="text" class="form-control @error('ingredients.'.$i) is-invalid @enderror {{ old('ingredients.'.$i) && !$errors->has('ingredients.'.$i) ? 'is-valid' : '' }}" name="ingredients[]" placeholder="材料 {{ $i + 1 }}." value="{{ $oldIngredients[$i] }}">
                                    @error('ingredients.'.$i)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <a href="#" class="btn btn-sm btn-danger remove-ingredient">削除</a>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">作り方</label>
                    <br>
                    <button type="button" class="my-1 btn btn-sm btn-primary add-step">＋</button>
                    <br>
                    <div class="steps-container">
                        @php
                        // 前回のフォーム入力値（またはデフォルト値）を取得
                        $oldDescriptions = old('descriptions', $steps->pluck('description')->toArray());
                        // 入力値の数を取得
                        $count = count($oldDescriptions);
                    @endphp
                    @if($count > 0)
                        @for($i = 0; $i < $count; $i++)
                            <div class="mb-2 step-item">
                                <!-- 手順の入力フィールド -->
                                <input type="text" class="form-control @error('descriptions.'.$i) is-invalid @enderror {{ old('descriptions.'.$i) && !$errors->has('descriptions.'.$i) ? 'is-valid' : '' }}"
                                    name="descriptions[]" placeholder="作り方 {{ $i + 1 }}." value="{{ $oldDescriptions[$i] }}">
                                <!-- エラーメッセージの表示 -->
                                @error('descriptions.'.$i)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- 手順削除ボタン -->
                                <a href="#" class="btn btn-sm btn-danger remove-step">削除</a>
                            </div>
                        @endfor
                    @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="mt-2 btn btn-warning" style="width:90px;">更新する</button>
                    <button type="button" class="mt-2 btn btn-danger" style="width:90px;margin-left: 8px;"onclick="confirmDelete()">削除</button>
                </div>
            </div>

        </div>
    </form>
    <form id="delete-form" action="{{ route('recipe.destroy', $recipe->id) }}" method="post" class="d-none">
        @csrf
        @method('DELETE')
    </form>
    <div class="row">
        <div class="card col-md-6 text-center border-0 shadow-none bg-transparent">
        </div>
    </div>
</div>

@stop

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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

    // 評価しましたのアラートを表示
    ratingSuccessMessage.style.display = 'block';


    // 3秒後にアラートを非表示にする
    setTimeout(() => {
        ratingSuccessMessage.style.display = 'none';
                // フォームをサブミット
    document.getElementById('rating-form').submit();
    }, 1000);

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

    document.addEventListener('DOMContentLoaded', function () {
        // 材料追加ボタンのクリックイベントをリッスン
        document.querySelector('.add-ingredient').addEventListener('click', function () {
            const container = document.querySelector('.ingredients-container');
            const newIngredientItem = document.createElement('div');
            newIngredientItem.className = 'ingredient-item';

            const newTextArea = document.createElement('input');
            newTextArea.name = 'ingredients[]'; // テキストエリアの名前
            newTextArea.className = 'form-control'; // 追加されるテキストエリアにも余白を追加

            newTextArea.placeholder = '材料';
            const removeLink = document.createElement('a');
            removeLink.href = '#';
            removeLink.className = 'btn btn-sm btn-danger remove-ingredient mb-2';
            removeLink.textContent = '削除';

            newIngredientItem.appendChild(newTextArea);
            newIngredientItem.appendChild(removeLink);
            container.appendChild(newIngredientItem);
        });

        // 作り方追加ボタンのクリックイベントをリッスン
        document.querySelector('.add-step').addEventListener('click', function () {
            const container = document.querySelector('.steps-container');
            const newStepItem = document.createElement('div');
            newStepItem.className = 'step-item';

            const newTextArea = document.createElement('input');
            newTextArea.type = 'text';
            newTextArea.name = 'descriptions[]'; // テキストエリアの名前
            newTextArea.className = 'form-control'; // 追加されるテキストエリアにも余白を追加
            // 作り方の順番を取得
            const lastStepOrder = container.querySelectorAll('.step-item').length + 1;

            newTextArea.placeholder = '作り方 ' + lastStepOrder + '.'; // 作り方の順番を設定

            const removeLink = document.createElement('a');
            removeLink.href = '#';
            removeLink.className = 'btn btn-sm btn-danger remove-step mb-2';
            removeLink.textContent = '削除';

            newStepItem.appendChild(newTextArea);
            newStepItem.appendChild(removeLink);
            container.appendChild(newStepItem);
        });

        // 削除リンクのクリックイベントをリッスン
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-ingredient') || event.target.classList.contains('remove-step')) {
                const item = event.target.closest('.ingredient-item, .step-item');
                if (item) {
                    item.remove();
                }
            }
        });
    });
</script>
<script>
    function confirmDelete() {
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>

@stop 

