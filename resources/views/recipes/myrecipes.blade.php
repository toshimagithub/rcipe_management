@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center">マイレシピ</h1>
@stop


@section('content')
<div class="row">
@if(session('message'))
    <div class="p-3 mb-2 bg-warning text-dark text-center">
    {{ session('message') }}
    </div>
@endif
</div>
    <div class="row">
        @foreach ($recipes as $recipe)
        <div class="col-md-4 col-sm-4 recipe-container">
                <a href="{{ route('recipe.show', [$recipe->id]) }}">
                    @if ($recipe->image &&($recipe->created_at->diffInDays(now()) < 1 ))
                        <div class="ribbon-wrapper ribbon-lg">
                            <div class="ribbon bg-warning">
                                NEW
                            </div>
                        </div>
                    @endif
                        <img class="rounded hover-zoom" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Recipe Image">
                        <p class="recipe-title"> 
                            <strong>{{ $recipe->name }}</strong>
                            @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $recipe->averageStar)
                                <span class="bi bi-star-fill" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                            @else
                                    @if ($i - 0.5 <= $recipe->averageStar)
                                        <span class="bi bi-star-half" data-rating="{{ $i }}" style="color: #FFD700;"></span>
                                    @else
                                        <span class="bi bi-star" data-rating="{{ $i }}" style="color: #c0c0c0;"></span>
                                    @endif
                                @endif
                            @endfor
                        </p>
                </a>
                <div class="row" style="height: 25px;">
                    <div class="col-md-12">
                        <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="py-1 text-center">
                    <a href="{{ route('recipe.edit', [$recipe->id]) }}" class="btn btn-warning mt-1">編集</a><br>
                </div>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
@stop
