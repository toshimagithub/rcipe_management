@extends('adminlte::page')

@section('content_header')
<style>
.mb {
    margin-bottom: 50px !important;
  }
</style>
<div class="container text-center">
  <div class="row">
    <div class="col"></div>
    <div class="col">
      <a href="{{ route('recipe.update', [$recipe->id]) }}"class="btn btn-warning">更新する</a>
    </div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
</div>

@stop

@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-8 mb-2">
          <div class="star-rating">
              <form id="rating-form" action="{{ route('recipe.review', [$recipe->id]) }}" method="POST">
                  @csrf <!-- CSRFトークンを追加 -->
                  <div class="d-flex align-items-center">
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
</div>

<div class="container">



    <div class="row justify-content-center align-items-center">
        <!-- レシピ名と画像 -->
        <div class="col-md-6 text-center">
          <input type="file" placeholder="写真" name="image">
            <h4 class="mt-2"><b>{{ $recipe->name }}</b></h4>

      
            @if($recipe->image)
                <img src="{{ asset('storage/images/'.$recipe->image) }}" class="rounded" style="max-height:300px; width:auto;">
            @endif



            <div class="text-sm font-semibold flex flex-row-reverse mb-3">
                <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
            </div>

            <label>コメント</label>
            <br>
            <textarea class="w-auto py-2 border border-gray-300 rounded-md font-semibold whitespace-pre-line" cols="60" rows="３"  style="border-radius: 10px;">{{ $recipe->comment }}</textarea>
        </div>

        <!-- 材料、作り方、コメント -->
        <div class="col-md-6">
            <div class="mb-3">
                <label>材料</label>
            </div>
            @foreach($ingredients as $ingredient)
                <div style="text-decoration: underline;">
                  <input type="text" style="border:none; background-color: transparent; text-decoration: underline; width: 600px;" value="{{ $ingredient->ingredient }}">
                  </input>
                    <br>
                </div>
            @endforeach

            <br>

            <label>作り方</label>
            @foreach($steps as $step)
                <div class="d-flex" style="text-decoration: underline;">
                    {{-- <input type="text" style="border:none; background-color: transparent; text-decoration: underline; width:20px;" value="">
                    </input> --}}
                    <input type="text" style="border:none; background-color: transparent; text-decoration: underline; width: 600px;" value="{{ $step->order }}.{{ $step->description }}">
                    <br>
                </div>
            @endforeach


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
</script>

@stop

