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
            <form action="{{ url('/upload/result')}}" method="POST" ref="form" @submit.prevent="submit" enctype="multipart/form-data">
                {{ csrf_field() }}
                <h1>ファイルアップローダー</h1>
                <div class="mb-3">
                    <label for="contents" class="control-label">アップロードファイル（5MBまで）&nbsp;<span class="badge rounded-pill text-bg-danger" >必須</span></label>
                    <input type="file" class="form-control" id="contents" name="contents" @change="changeFile" ref="file" v-if="init"></input>
                    <p class="text-danger">@{{form_attributes.file.error_message}}</p>
                </div>
                <div class="mb-3">
                    <label for="mail" class="control-label">メールアドレス&nbsp;<span class="badge rounded-pill text-bg-danger">必須</span></label>
                    <input type="mail" class="form-control" id="mail" name="mail" v-model="form_attributes.mail.value" @input="onInput('mail')"></input>
                    <p class="text-danger">@{{form_attributes.mail.error_message}}</p>
                </div>
                <div class="mb-3">
                    <label for="limit_date" class="control-label">掲載期限（翌日～7日後まで）&nbsp;<span class="badge rounded-pill text-bg-danger">必須</span></label>
                    <input type="date" class="form-control" id="limit_date" name="limit_date" v-model="form_attributes.limit_date.value" min="{{$tomorrow}}" max="{{$nextweek}}" @input="onInput('limit_date')"></input>
                    <p class="text-danger">@{{form_attributes.limit_date.error_message}}</p>
                </div>
                <div class="mb-3">
                    <label for="password" class="control-label">パスワード&nbsp;<span class="badge rounded-pill text-bg-light">任意</span></label>
                    <input type="text" class="form-control" id="password" name="password" v-model="form_attributes.password.value"></input>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" name="add" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
        <script type="module">
        const app = {
            el: '#app',
            data() {
                return{
                    limit: 5,
                    unit: 'MB',
                    unit_size:1000000,
                    init:true,
                    form_attributes: {
                        file:{
                            value: '',
                            error_message:''
                        },
                        mail:{
                            value: '',
                            error_message:''
                        },
                        limit_date:{
                            value: '',
                            error_message:''
                        },
                        password:{
                            value: '',
                            error_message:''
                        },
                    },
                }
            },
            methods: {
                checkValidate() {
                    var ret = true;
                    Object.keys(this.form_attributes).forEach(function (key) {
                        const error_message = this.Validation(key, this.form_attributes[key].value)
                        if (error_message === true) {
                            this.form_attributes[key].error_message = '';
                        } else {
                            this.form_attributes[key].error_message = error_message;
                            ret = false;
                        }
                    }, this)
                    return ret;
                },
                Validation(attribute, value) {
                    switch (attribute){
                        case 'mail':
                            return this.mailValidate(value);
                            break;
                        case 'limit_date':
                            return this.dateValidate(value);
                            break;
                        case 'password':
                            return this.passwordValidate(value);
                            break;
                        case 'file':
                            if (!this.form_attributes['file'].value) {
                                return "ファイルを設定してください";
                            }else{
                                return true;
                            }
                            break;
                        default:
                            return true;
                    }
                },
                fileValidate(file) {
                    if (!file) {
                        return false;
                    }
                    const limit_file_size = this.limit * this.unit_size;
                    if (parseInt(file.size) > limit_file_size) {
                        this.form_attributes['file'].error_message = this.limit + this.unit + '未満のファイルのみアップロード可能です';
                        return false;
                    }
                    this.form_attributes['file'].error_message = '';
                    return true;
                },
                mailValidate(mail) {
                    if (!mail) {
                        return 'メールアドレスを入力してください';
                    }
                    const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
                    if (!regex.test(mail)) {
                        return 'メールアドレスの形式が不正です';
                    }
                    return true;
                },
                dateValidate(date) {
                    if (!date) {
                        return '掲載期限を入力してください';
                    }
                    return true;
                },
                passwordValidate(date) {
                    return true;
                },
                changeFile(e) {
                    const files = e.target.files || e.dataTransfer.files
                    if (this.fileValidate(files[0])) {
                        this.form_attributes['file'].value = files[0].name;
                    } else {
                        this.form_attributes['file'].value = '';
                    }
                },
                onInput(key){
                    this.form_attributes[key].error_message = '';
                },
                submit(){
                    if(this.checkValidate()){
                        if(confirm('ファイルをアップロードします。よろしいですか？')){
                            this.$refs.form.submit();

                            //フォームの初期化
                            this.init = false;
                            Object.keys(this.form_attributes).forEach(function (key) {
                                this.form_attributes[key].value = '';
                                this.form_attributes[key].error_message = '';
                            }, this);
                        }
                    }else{
                        alert('入力エラーがあります');
                    }
                }
            },
        }
        Vue.createApp(app).mount('#app')
        </script>
    </body>

</html>