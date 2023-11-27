@extends('adminlte::page')


@section('content_header')
<div class="row">
    <div class="col-md-4">
        {{-- データを登録するわけではないから methodがgetになる --}}
    <form id="rating-form" method="get" action="{{ route('recipe.sortRating') }}">
            <div id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                <span class="bi bi-star-fill star {{ $i == $star ? 'selected' : '' }}" data-rating="{{ $i }}" style="color: {{ $i <= $star ? '#FFD700' : '#c0c0c0' }}"></span>
                @endfor
                <div class="ms-3 rating-button-container">
                    <input type="hidden" id="selected-rating" name="star" value="{{ old('star', $star) }}">
                    <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm me-3">実行する</button>
                </div>
            </div>
        </form>
        </form>
    </div>
    <div class="col-md-4 text-center">
        <h1 >マイレビュー</h1>
    </div>

</div>
@stop

@section('content')

<div class="row text-center">
@foreach ($recipes as $recipe)
    <div class="col-md-4">
        <a href="{{ route('recipe.show', [$recipe->id]) }}">
            @if ($recipe->image &&($recipe->created_at->diffInDays(now()) < 1 ))
            <div class="ribbon-wrapper ribbon-lg">
                <div class="ribbon bg-warning">
                    NEW
                </div>
            </div>
        @endif
                <img class="rounded" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Recipe Image">

                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $recipe->pivot->star)
                        <span class="bi bi-star-fill" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                    @else
                        <span class="bi bi-star" data-rating="{{ $i }}" style="color: #c0c0c0;"></span>
                    @endif
                @endfor
                <br>
        </a>
                <div class="row">
            <div class="col-md-4" >
            </div>
            <div class="col-md-4 " >
                <strong>{{ $recipe->name }}</strong>
            </div>
            <div class="col-md-4 text-right">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

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