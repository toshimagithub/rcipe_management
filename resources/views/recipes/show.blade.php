@extends('adminlte::page')

@section('content_header')
<style>
.mb {
    margin-bottom: 85px !important;
  }
  </style>
<div class="mb">
</div>
@stop

@section('content')

<div class="container">
    <div class="row justify-content-center align-items-center">
        <!-- レシピ名と画像 -->
        <div class="col-md-6 text-center">
            <h4><b>{{ $recipe->name }}</b></h4>
            
            @if($recipe->image)
                <img src="{{ asset('storage/images/'.$recipe->image) }}" class="rounded" style="max-height:300px; width:auto;">
            @endif

            <div class="text-sm font-semibold flex flex-row-reverse mb-3">
                <p>{{ $recipe->user ? $recipe->user->name : 'ユーザーが存在しません' }} / {{ $recipe->created_at->diffForHumans() }}</p>
            </div>

            <label>コメント</label>
            <br>
            <textarea class="w-auto py-2 border border-gray-300 rounded-md font-semibold whitespace-pre-line" cols="60" rows="３" readonly style="resize: none; border-radius: 10px;">{{ $recipe->comment }}</textarea>
        </div>

        <!-- 材料、作り方、コメント -->
        <div class="col-md-6">
            <div class="mb-3">
                <label>材料</label>
            </div>
            @foreach($ingredients as $ingredient)
                <div style="text-decoration: underline;">
                    {{ $ingredient->ingredient }}<br>
                </div>
            @endforeach

            <br>

            <label>作り方</label>
            @foreach($steps as $step)
                <div style="text-decoration: underline;">
                    <span>{{ $step->order }}.</span>
                    <span>{{ $step->description }}</span>
                    <br>
                </div>
            @endforeach


        </div>
    </div>
</div>



@stop

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
@stop
