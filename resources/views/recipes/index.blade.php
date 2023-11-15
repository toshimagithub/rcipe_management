@extends('adminlte::page')


@section('content_header')
    <h1>レシピ一覧</h1>
@stop

@section('content')


    <div class="row">
        @foreach ($recipes as $recipe)
            @if ($recipe->image)
                <div class="col-md-4">
                    <img class="rounded" src="{{ asset('storage/images/'.$recipe->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Recipe Image">
                    <br>
                    <text>
                        <strong>{{ $recipe->name }}</strong>
                    </text>
                </div>
            @endif
        @endforeach
    </div>




@stop

@section('css')
@stop

@section('js')
@stop
