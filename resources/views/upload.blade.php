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
        <div class="container">
        <h1>ファイルアップローダー</h1>
        <form action="{{ url('/message/add')}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="password" class="control-label">アップロードファイル&nbsp;<span class="badge rounded-pill text-bg-danger">必須</span></label>
                <input type="file" class="form-control" id="contents" name="contents" ></input>
            </div>
            <div class="mb-3">
                <label for="mail" class="control-label">メールアドレス&nbsp;<span class="badge rounded-pill text-bg-danger">必須</span></label>
                <input type="mail" class="form-control" id="mail" name="mail"></input>
            </div>
            <div class="mb-3">
                <label for="limit" class="control-label">掲載期限&nbsp;<span class="badge rounded-pill text-bg-danger">必須</span></label>
                <input type="date" class="form-control" id="limit" name="limit" min="{{$tomorrow}}" max="{{$nextweek}}"></input>
            </div>
            <div class="mb-3">
                <label for="password" class="control-label">パスワード&nbsp;<span class="badge rounded-pill text-bg-light">任意</span></label>
                <input type="text" class="form-control" id="password" name="password"></input>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" name="add" class="btn btn-primary">登録</button>
            </div>
        </form>
        </div>
    </body>

</html>