@if (count($errors) > 0)
<!-- フォームのエラーリスト -->
<div class="alert alert-danger text-center">
    <strong>エラーが起こっています。</strong>
 
    <br><br>
 
    <ul class="text-center">
        @foreach ($errors->all() as $error)
        <li style="list-style: none;">{{ $error }}</li>
        @endforeach
    </ul>
    
</div>
@endif