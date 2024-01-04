@extends('adminlte::page')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4 text-center">
            <h1>管理者権限付与</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row text-center justify-content-center">
        @foreach ($users as $user)
            <div class="card w-75">
                <div class="row text-center">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-3">
                        <strong>{{ $user->name }}</strong>
                    </div>
                    <div class="col-md-3">
                        <strong>
                            @if($user->recipes()->count() === 0)
                                まだレシピを投稿していません
                            @else
                                {{ $user->recipes()->count() }} レシピ
                            @endif
                        </strong>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-2">
                        <strong>
                            @if ($user->role == "管理者")
                                <p style="color: green;">管理人</p>
                            @else
                                <p style="color: red;">ユーザー</p>
                            @endif
                        </strong>
                    </div>
                    <div class="col-md-3 mb-1">
                        <form action="{{ route('admin.grant', [$user->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <button type="submit" class="btn btn-success" style="width:137px">管理者にする</button>
                        </form>
                    </div>
                    <div class="col-md-3 mb-1">
                        <form action="{{ route('admin.revoke', [$user->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            @if(Auth::user()->id !== $user->id)
                                <button type="submit" class="btn btn-danger">ユーザーに戻す</button>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-4 ">
                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            @if(Auth::user()->id !== $user->id)
                                <button type="submit" class="btn btn-warning" onclick='return confirm("本当に削除しますか？")' style="width:137px">
                                    ユーザー削除
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-LYZSwM+Np3WeP25QQl/Td4l77Zn2KrKp2Wuk9aRU+5h6PKDcZO8YlEy6s6FcpkWA" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-Td6Qj/Rn9aVW/3v5omSFhj7dU1P91CB5Cr2kLoe6lNFyQuA7FbYBAKs1cr5DsYVR" crossorigin="anonymous"></script>
@stop
