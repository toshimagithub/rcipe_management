@extends('adminlte::page')

@section('title', 'レシピ登録')

@section('content_header')
    <h1>レシピ登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form action="{{ url('recipes/store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body">

                        <input type="file" name="image" class="mb-3">

                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control"  name="name" placeholder="名前">
                        </div>

                        <div class="form-group">
                            <label for="type">材料</label>
                            <input type="text" class="form-control" name="ingredients[]" placeholder="種別">
                        </div>

                        <div class="form-group">
                            <label for="detail">コメント</label>
                            <input type="text" class="form-control" name="comment" placeholder="詳細説明">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
