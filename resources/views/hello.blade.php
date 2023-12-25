<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recipe PDF</title>
    <style>
        .recipe-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .recipe-info img {
            max-width: 100%;
            height: auto;
        }

    /* dompdf日本語文字化け対策 */
    /* フォントをみんなipagに設定しておかないと日本語にならない・・ */
    @font-face {
        font-family: 'ipag';
        font-style: normal;
        font-weight: normal;
        src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'ipag';
        font-style: bold;
        font-weight: bold;
        src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
    }

    body {
    font-family: 'ipag', 'Arial', sans-serif;
    font-size: 12px; /* 適切なサイズに調整する */
    word-wrap: break-word; /* 長い単語を折り返す */
    text-align: left; /* テキストを左寄せに設定する */
}

html, body, textarea {
    font-family: 'ipag', 'Arial', sans-serif;
    font-size: 12px; /* 適切なサイズに調整する */
    word-wrap: break-word; /* 長い単語を折り返す */
    text-align: left; /* テキストを左寄せに設定する */
}

.recipe-info {
    text-align: left; /* タイトルを左寄せに設定する */
    margin-bottom: 20px;
}

.recipe-info img {
    max-width: 100%;
    height: auto;
}

.label {
    text-decoration: underline;
}
</style>
</head>
<body>
    <div class="recipe-info">
        <h1>{{ $recipe->name }}</h1>
    <div class="row">
        <img src="{{ $recipe->image }}" alt="" class="img-thumbnail" style="width: 22rem;">
    </div>
        <label>材料</label>
        @foreach($ingredients as $ingredient)
        <div style="text-decoration: underline;">
            {{ $ingredient->ingredient }}
        </div>
        @endforeach
        <label>作り方</label>
        @foreach($steps as $step)
            <div style="text-decoration: underline;">
                <span>{{ $step->order }}. {{ $step->description }}</span>
            </div>
        @endforeach

    </div>
</body>
</html>