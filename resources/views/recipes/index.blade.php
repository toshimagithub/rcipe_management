@extends('adminlte::page')


@section('content_header')
    <h1 class="text-center">レシピ一覧</h1>
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
            <br>
        </a>
        <div class="row">
            <div class="col-md-7 text-right" >
                <strong>{{ $recipe->name }}</strong>
            </div>
            <div class="col-md-5 text-center">
                <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stop
