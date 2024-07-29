<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>課題</title>
        <style>
            .mb-3 label{
                line-height:220%;
            }
        </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div id="app" class="container">
            <form action="{{ url('/download/check')}}" method="POST">
                {{ csrf_field() }}
                <h1>{{$error_message}}</h1>
                @if ($password_flg)
                    <div class="mb-3">
                        <label for="password" class="control-label">パスワード&nbsp;<span class="badge rounded-pill text-bg-danger" >必須</span></label>
                        <input type="text" class="form-control" id="password" name="password"></input>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">ダウンロード</button>
                    </div>
                    <input type="hidden" id="file_key" name="file_key" value="{{$file_key}}">
                @endif
            </form>
        </div>
    </body>

</html>