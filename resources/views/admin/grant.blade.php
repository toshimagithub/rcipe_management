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
    <div class="row text-center">
        @foreach ($users as $user)
        <div class="row justify-content-center">
          <div class="card col-md-12 w-50">
            <strong>{{ $user->name }}</strong>
            <div class="row py-3">
                  <div class="col-md-4">
                    @if ($user->role == "管理者")
                    <p style="color: green;">管理人</p>
                    @else
                    <p style="color: red;">ユーザー</p>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <form action="{{ route('admin.grant', [$user->id]) }}" method="post" enctype="multipart/form-data">
                      @method('PATCH')
                      @csrf
                    <button type="submit" class="btn btn-success">管理者にする</button>
                    </form>
                  </div>
                  <div class="col-md-4">
                    <form action="{{ route('admin.revoke', [$user->id]) }}" method="post" enctype="multipart/form-data">
                      @method('PATCH')
                      @csrf
                    <button type="submit" class="btn btn-danger">ユーザーに戻す</button>
                  </form>
                  </div>
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
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
