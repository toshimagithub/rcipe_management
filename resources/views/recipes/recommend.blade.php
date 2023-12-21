@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center">オススメレシピ</h1>
@stop

@section('content')
<div class="row">
    @foreach ($recipes as $recipe)
    <div class="sumaho col-sm-4 col-md-3 recipe-container">
        <a href="{{ route('recipe.show', [$recipe->id]) }}">
                @if ($recipe->image && ($recipe->created_at->diffInDays(now()) < 1))
                    <div class="ribbon-wrapper">
                        <div class="ribbon bg-warning">
                            new
                        </div>
                    </div>
                @endif
                <img class="rounded hover-zoom" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; object-fit: cover;" alt="Recipe Image">
                <p class="recipe-title">
                    <strong>{{ $recipe->name }}</strong>
                    <br>
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
            <div class="row">
                <div class="col-md-12">
                    <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @if(Auth::check() && Auth::user()->role === "管理者")
            <div class="row text-center" >
                <div class="col-md-12">
                    @if ($recipe->おすすめ == 1)
                    <p style="color: green;">管理人のおすすめ</p>
                    @else
                    <p style="color: red;">おすすめになっていません</p>
                    @endif
                </div>
                <div class="col-md-12">
                <form action="{{ route('admin.unRecommend', [$recipe->id]) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                <button type="submit" class="btn btn-danger mb-1">おすすめを解除</button>
                </form>
                </div>
            </div>
            @endif
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
