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
            [v-cloak] {
                display: none;
            }
        </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div id="app" class="container" v-cloak>
            <form action="{{ url('/download/result')}}" method="POST">
                {{ csrf_field() }}
                <h1>ダウンロード</h1>
                <div class="mb-3">
                    <label for="password" class="control-label">パスワード&nbsp;<span class="badge rounded-pill text-bg-light">任意</span></label>
                    <input type="text" class="form-control" id="password" name="password" v-model="form_attributes.password.value"></input>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" name="add" class="btn btn-primary">ダウンロード</button>
                </div>
            </form>
        </div>
    </body>

</html>