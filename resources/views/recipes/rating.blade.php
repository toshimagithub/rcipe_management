@extends('adminlte::page')


@section('content_header')
    <h1 class="text-center">マイレビュー</h1>
@stop

@section('content')

<div class="row text-center">
  @foreach ($recipes as $recipe)
    <div class="col-md-4">
        <a href="{{ route('recipe.show', [$recipe->id]) }}">
            @if ($recipe->image)
                {{-- @if ($recipe->updated_at->diffInDays(now()) < 1 || $recipe->ingredients->max('updated_at')->diffInDays(now()) < 1 || $recipe->steps->max('updated_at')->diffInDays(now()) < 1)
                    <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-warning">
                            NEW
                        </div>
                    </div>
                @endif --}}
                <img class="rounded" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Recipe Image">

                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $recipe->pivot->star)
                        <span class="bi bi-star-fill" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                    @else
                        <span class="bi bi-star" data-rating="{{ $i }}" style="color: #c0c0c0;"></span>
                    @endif
                @endfor

                <br>
            @endif
        </a>
        <strong>{{ $recipe->name }}</strong>
        <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->updated_at->diffForHumans() }}</p>
    </div>
@endforeach

</div>
<footer class="small">
    <div class="mt-4">
        {{ $recipes->links('pagination::bootstrap-5') }}
    </div>
</footer>






@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stop
