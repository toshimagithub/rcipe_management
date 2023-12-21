@extends('adminlte::page')

@section('title', 'Register')

@section('content_header')
    <h1>レシピ登録</h1>
@stop

@section('content')
    <div class="row">
            <div class="card card-primary">
                <form action="{{ route('recipe.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="file" name="image" class="mb-1">
                        @if ($errors->has('image'))
                        <div class="error">{{ $errors->first('image') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="name">料理名</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror @if(old('name') && !$errors->has('name')) is-valid @endif" name="name" placeholder="料理名" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">材料</label>
                            <br>
                            <button type="button" class="my-1 btn btn-sm btn-primary add-ingredient">＋</button>
                            <br>
                            <div class="ingredients-container">
                                <div class="mb-2 ingredient-item">
                                    <input type="text"class="form-control @error('ingredients.0') is-invalid @enderror {{ old('ingredients.0') && !$errors->has('ingredients.0') ? 'is-valid' : '' }}"
                                    name="ingredients[]"placeholder="材料を１つずつ入力してください" value="{{ old('ingredients.0') }}">
                                    @error('ingredients.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                <a href="#" class="btn btn-sm btn-danger remove-ingredient">削除</a>
                                </div>
                                @php
                                    $oldIngredients = old('ingredients', []); // バリデーションエラーがある場合に古い値を取得し、デフォルトで空の配列を使用
                                    $count = count($oldIngredients);
                                @endphp
                                @if($count > 1)
                                    @for($i = 1; $i < $count; $i++)
                                        <div class="mb-2 ingredient-item">
                                    <input type="text" class="form-control @error('ingredients.'.$i-1) is-invalid  @enderror {{ old('ingredients.'.$i-1) && !$errors->has('ingredients.'.$i-1) ? 'is-valid' : '' }}" name="ingredients[]" placeholder="材料 {{ $i + 1 }}." value="{{ $oldIngredients[$i] }}">
                                    @error('ingredients.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <a href="#" class="btn btn-sm btn-danger remove-ingredient">削除</a>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">作り方</label>
                            <br>
                            <button type="button" class="my-1 btn btn-sm btn-primary add-step">＋</button>
                            <br>
                            <div class="steps-container">
                                <div class="mb-2 step-item">
                                    <input type="text" class="form-control @error('descriptions.0') is-invalid @enderror {{ old('descriptions.0') && !$errors->has('descriptions.0') ? 'is-valid' : '' }}" name="descriptions[]" placeholder="作り方の工程を１つずつ入力してください" value="{{ old('descriptions.0') }}">
                                    @error('descriptions.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <a href="#" class="btn btn-sm btn-danger remove-step">削除</a>
                                </div>
                                @php
                                    $oldDescriptions = old('descriptions', []); // バリデーションエラーがある場合に古い値を取得し、デフォルトで空の配列を使用
                                    $count = count($oldDescriptions);
                                @endphp
                                @if($count > 1)
                                    @for($i = 1; $i < $count; $i++)
                                        <div class=" mb-2 step-item">
                                            <input type="text" class="form-control @error('descriptions.'.$i-1) is-invalid  @enderror {{ old('descriptions.'.$i-1) && !$errors->has('descriptions.'.$i-1) ? 'is-valid' : '' }}"
                                            name="descriptions[]" placeholder="作り方 {{ $i + 1 }}." value="{{ $oldDescriptions[$i] }}">
                                            @error('descriptions.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <a href="#" class="btn btn-sm btn-danger remove-step">削除</a>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="detail">コメント</label>
                            <input type="text" class="form-control @error('comment') is-invalid @enderror @if(old('comment') && !$errors->has('comment')) is-valid @endif" " name="comment" placeholder="コメント" value="{{ old('comment') }}">
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 材料追加ボタンのクリックイベントをリッスン
        document.querySelector('.add-ingredient').addEventListener('click', function () {
            const container = document.querySelector('.ingredients-container');
            const newIngredientItem = document.createElement('div');
            newIngredientItem.className = 'ingredient-item';

            const newTextArea = document.createElement('input');
            newTextArea.name = 'ingredients[]'; // テキストエリアの名前
            newTextArea.className = 'form-control'; // 追加されるテキストエリアにも余白を追加

            newTextArea.placeholder = '材料';
            const removeLink = document.createElement('a');
            removeLink.href = '#';
            removeLink.className = 'btn btn-sm btn-danger remove-ingredient mb-2';
            removeLink.textContent = '削除';

            newIngredientItem.appendChild(newTextArea);
            newIngredientItem.appendChild(removeLink);
            container.appendChild(newIngredientItem);
        });

        // 作り方追加ボタンのクリックイベントをリッスン
        document.querySelector('.add-step').addEventListener('click', function () {
            const container = document.querySelector('.steps-container');
            const newStepItem = document.createElement('div');
            newStepItem.className = 'step-item';

            const newTextArea = document.createElement('input');
            newTextArea.type = 'text';
            newTextArea.name = 'descriptions[]'; // テキストエリアの名前
            newTextArea.className = 'form-control'; // 追加されるテキストエリアにも余白を追加
            // 作り方の順番を取得
            const lastStepOrder = container.querySelectorAll('.step-item').length + 1;

            newTextArea.placeholder = '作り方 ' + lastStepOrder + '.'; // 作り方の順番を設定

            const removeLink = document.createElement('a');
            removeLink.href = '#';
            removeLink.className = 'btn btn-sm btn-danger remove-step mb-2';
            removeLink.textContent = '削除';

            newStepItem.appendChild(newTextArea);
            newStepItem.appendChild(removeLink);
            container.appendChild(newStepItem);
        });

        // 削除リンクのクリックイベントをリッスン
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-ingredient') || event.target.classList.contains('remove-step')) {
                const item = event.target.closest('.ingredient-item, .step-item');
                if (item) {
                    item.remove();
                }
            }
        });
    });
</script>
@stop
