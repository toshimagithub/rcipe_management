@extends('adminlte::page')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    並び替え
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('recipe.bestIndex') }}">評価が高い順</a></li>
                    <li><a class="dropdown-item" href="{{ route('recipe.worstIndex') }}">評価が低い順</a></li>
                    <li><a class="dropdown-item" href="{{ route('recipe.oldestIndex') }}">投稿が古い順</a></li>
                </ul>
            </div>
            <div class="ms-3">
                @if(request()->routeIs('recipe.bestIndex'))
                    <b>評価が高い順</b>
                @endif
                @if(request()->routeIs('recipe.worstIndex'))
                    <b>評価が低い順</b>
                @endif
                @if(request()->routeIs('recipe.oldestIndex'))
                    <b>投稿が古い順</b>
                @endif
            </div>
        </div>
        <div class="col-md-4 text-center">
            <h1>管理者ピックアップ</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row text-center">
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
                <div class="row" >
                    <div class="col-md-12">
                        <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if ($recipe->おすすめ == 1)
                            <p  style="color: green;">管理人のおすすめ</p>
                        @else
                            <p  style="color: red;">おすすめになっていません</p>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('admin.recommend', [$recipe->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <button  type="submit" class="btn btn-success">おすすめにする</button>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('admin.unRecommend', [$recipe->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <button type="submit" class="btn btn-danger">おすすめを解除</button>
                        </form>
                    </div>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
