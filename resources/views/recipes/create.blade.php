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
                <form action="{{ route('recipe.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body">

                        <input type="file" name="image" class="mb-3">

                        <div class="form-group">
                            <label for="name">料理名</label>
                            <input type="text" class="form-control"  name="name" placeholder="名前">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">材料</label>
                            <br>
                            <button type="button" class="my-1 btn btn-sm btn-primary add-ingredient">＋</button>
                            <br>
                            <div class="ingredients-container">
                            <div class="mb-2 ingredient-item">
                                <input type="text"  class="form-control" name="ingredients[]" placeholder="材料"></input>
                                <a href="#" class="btn btn-sm btn-danger remove-ingredient">削除</a>
                            </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">作り方</label>
                            <br>
                            <button type="button" class="my-1 btn btn-sm btn-primary add-step">＋</button>
                            <br>
                            <div class="steps-container">
                                <div class="mb-2 step-item">
                                    <input type="text" class="form-control" name="descriptions[]" placeholder="作り方 1.">
                                    <a href="#" class="btn btn-sm btn-danger remove-step">削除</a>
                                </div>
                            </div>
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
