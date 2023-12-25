@extends('adminlte::page')

@section('title', 'MyReview')

@section('content_header')
<div class="row">
    <div class="col-md-4 col-sm-4">
        {{-- データを登録するわけではないから methodがgetになる --}}
    <form id="rating-form" method="get" action="{{ route('recipe.sortRating') }}">
            <div id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                <span class="bi bi-star-fill star {{ $i == $star ? 'selected' : '' }}" data-rating="{{ $i }}" style="color: {{ $i <= $star ? '#FFD700' : '#c0c0c0' }}"></span>
                @endfor
                <div class="rating-button-container">
                    <input type="hidden" id="selected-rating" name="star" value="{{ old('star', $star) }}">
                    <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm me-3">星で絞り込む</button>
                </div>
            </div>
    </form>
    </div>
    <div class="col-md-4 col-sm-4 text-center">
        <h1 >マイレビュー</h1>
    </div>

</div>
@stop

@section('content')

<div class="row">
@foreach ($recipes as $recipe)
    <div class="sumaho col-sm-4 col-md-3 recipe-container">
        <a href="{{ route('recipe.show', [$recipe->id]) }}">
            @if ($recipe->image &&($recipe->created_at->diffInDays(now()) < 1 ))
                <div class="ribbon-wrapper">
                    <div class="ribbon bg-warning">
                        new
                    </div>
                </div>
            @endif
                <img class="rounded hover-zoom" src="{{ $recipe->image }}" style="width: 100%; object-fit: cover;" alt="Recipe Image">
                <p class="recipe-title">
                    <strong>{{ $recipe->name }}</strong>
                    <br>
                    @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $recipe->pivot->star)
                        <span class="bi bi-star-fill" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                    @else
                        <span class="bi bi-star" data-rating="{{ $i }}" style="color: #c0c0c0;"></span>
                    @endif
                @endfor

                </p>

        </a>
        <div class="row">
            <div class="col-md-12">
                <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
@endforeach


</div>
@if ($recipes->isEmpty())
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4 text-center" style="margin-top: 100px">
        <p>まだ星の評価がありません。</p>
        <p>レシピを見て星の評価をしましょう。</p>
    </div>
</div>
@endif

<footer class="small">
    <div class="mt-4">
        {{ $recipes->appends(request()->input())->links('pagination::bootstrap-5') }}
    </div>
</footer>


@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@stop

@section('js')

<script>
    const stars = document.querySelectorAll('.star');
    const ratingButton = document.getElementById('submit-rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            document.getElementById('selected-rating').value = rating;
            updateStars(rating);
        });
    });

    ratingButton.addEventListener('click', () => {
        document.getElementById('rating-form').submit();
    });

    function updateStars(rating) {
        stars.forEach(star => {
            const starRating = star.getAttribute('data-rating');
            if (starRating <= rating) {
                star.style.color = '#FFD700';
            } else {
                star.style.color = '#c0c0c0';
            }
        });
    }
</script>
@stop