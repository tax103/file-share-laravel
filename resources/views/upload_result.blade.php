<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>アップロード結果</title>
        <style>
            .mb-3 label{
                line-height:220%;
            }
        </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="container">
        <h1>{{$message}}</h1>
            <div class="mb-3">
                <textarea id="file_url" readonly style="width:50%">{{$file_url}}</textarea>
            </div>
            <div class="mb-3">
                <button type="button" name="copy" onclick="copyUrl()" class="btn btn-primary">URLをコピー</button>
                <button type="button" name="back" class="btn btn-primary" onclick="location.href='/upload'">前のページにもどる</button>
            </div>
        </div>
        <script>
            function copyUrl(){
                var txt = document.getElementById('file_url').value;
                navigator.clipboard.writeText(txt);
                alert("コピーしました\n" + txt);
            }
        </script>
    </body>

</html>