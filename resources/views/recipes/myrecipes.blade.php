@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center">マイレシピ</h1>
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
                <a href="{{ route('recipe.edit', [$recipe->id]) }}" class="btn btn-warning mt-1">編集</a><br>
                <div class="d-flex justify-content-center">
                    <b class="ms-2">{{ $recipe->name }}</b>
                    <p class="">{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
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
