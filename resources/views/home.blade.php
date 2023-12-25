@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<div class="row">
    <div class="col-md-6 text-center">
        <h1>今日のおすすめ</h1>
    </div>
    <div class="col-md-6 text-right">
        @if(Auth::check() && Auth::user()->role === "管理者")
        <a class="btn btn-success hover-zoom" href="{{ route('admin.index') }}">管理者ピックアップ</a>
        <a class="btn btn-success hover-zoom" href="{{ route('admin.management') }}">管理者権限付与</a>
        @endif
    </div>
</div>

@stop

@section('content')
<div class="row">
    <div class=" col-sm-12 col-md-6 d-flex justify-content-center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($recipes as $index => $recipe)
                <div class="sumaho-index carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row">
                        <a href="{{ route('recipe.show', [$recipe->id]) }}">
                            <div class="image-container">
                                <img class="rounded hover-zoom" src="{{ $recipe->image }}" style="width: 100%; object-fit: cover;" alt="Recipe Image">
                            </div>
                        </a>
                    </div>
                    <div class="row text-center">
                        <strong>{{ $recipe->name }}</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-1-2/js/6-1-2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
