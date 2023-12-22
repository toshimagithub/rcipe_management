@extends('adminlte::page')

@section('title', 'Recipe')

@section('content_header')
<div class="row">
    @if(session('message'))
        <div class="p-3 mb-2 bg-warning text-dark text-center w-100">
        {{ session('message') }}
        </div>
    @endif
</div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="star-rating text-center">
                    <form id="rating-form" action="{{ route('recipe.review', [$recipe->id]) }}" method="POST">
                        @csrf <!-- CSRFトークンを追加 -->
                            <div class="center-block">
                            <span class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="bi bi-star-fill star" data-rating="{{ $i }}" style="color: {{ $i <= (optional($recipesReview)->star ?? 0) ? '#FFD700' : '#c0c0c0' }}"></span>
                                @endfor
                            </span>
                            <span class="ms-3 rating-button-container text-center">
                                <input type="hidden" id="selected-rating" name="selected-star" value="{{ optional($recipesReview)->star ?? 0 }}">
                                <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm">評価する</button>
                            </span>
                        </div>
                    </form>
                    <div id="rating-success-message" style="display: none;" class="alert alert-success mt-2 text-center">
                        評価しました！
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>


            <div class="row">
                <!-- レシピ名と画像 -->
                <div class="card  col-sm-6 col-md-6 text-center border-0 shadow-none bg-transparent">
                    <h4><b>{{ $recipe->name }}</b></h4>
                    @if($recipe->image)
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" class="rounded" style="height:auto; width:auto;">
                    @endif
                    <div class="text-sm font-semibold flex flex-row-reverse mb-1">
                        <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                    </div>
                    <label>コメント</label>
                    <textarea class="w-auto py-2 border border-gray-300 rounded-md font-semibold whitespace-pre-line" cols="60" rows="6" readonly style="resize: none; border-radius: 10px; height: 150px;">{{ $recipe->comment }}</textarea>
                </div>

                <div class="card col-sm-6 col-md-6 border-0 shadow-none bg-transparent mt-1">
                    <div class="mb-3">
                        <label>材料</label>
                    </div>
                    @foreach($ingredients as $ingredient)
                        <div style="text-decoration: underline;">
                            {{ $ingredient->ingredient }}
                        </div>
                    @endforeach
                    <label>作り方</label>
                    @foreach($steps as $step)
                        <div style="text-decoration: underline;">
                            <span>{{ $step->order }}. {{ $step->description }}</span>
                        </div>
                    @endforeach
                    <div>
                        <a href="{{ route('pdf', [$recipe->id]) }}" class="btn btn-warning mt-1">pdfにする</a><br>
                    </div>
                </div>
            </div>
    </div>
@stop

@section('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

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

        // 更新ボタンがクリックされたときの処理
        const updateBtn = document.getElementById('updateBtn');

        updateBtn.addEventListener('click', async function () {
            // 非同期でデータをサーバーに送信して更新する処理を追加
            // 例: fetchやaxiosを使用してLaravelのルートに対してデータを送信
            // この部分に適切な非同期処理を追加
        });
    </script>
@stop

