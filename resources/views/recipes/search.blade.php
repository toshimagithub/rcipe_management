@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4 text-center">
          <h1>検索結果: "{{ $keyword }}"</h1>        </div>
    </div>
@stop

@section('content')
    <div class="row text-center">
        @foreach ($recipes as $recipe)
            <div class="col-md-4">
                <a href="{{ route('recipe.show', [$recipe->id]) }}">
                    @if ($recipe->image && ($recipe->created_at->diffInDays(now()) < 1))
                        <div class="ribbon-wrapper ribbon-lg">
                            <div class="ribbon bg-warning">
                                NEW
                            </div>
                        </div>
                    @endif
                    <img class="rounded" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Recipe Image">
                    <br>
                </a>
                <div class="row" >
                    <div class="col-md-4" style="height: 25px;">
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
                    </div>
                    <div class="col-md-4" style="height: 25px;">
                        <strong>{{ $recipe->name }}</strong>
                    </div>
                    <div class="col-md-4 texe-center" style="height: 25px;">
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
        <p>ありません</p>
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
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
