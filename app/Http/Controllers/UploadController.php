<?php

namespace App\Http\Controllers;

use App\Models\UploadItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function index () 
    {

        $d = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime($d . '+1 day'));
        $nextweek = date('Y-m-d', strtotime($d . '+1 week'));

        return view('upload', compact('tomorrow', 'nextweek'));
    }

    public function result (Request $request) 
    {
        $message = '';
        $file_url = '';

        //エラーチェック（サイズ、必須項目）
        $contents   = $request->file('contents');
        $mail       = $request->input('mail');
        $limit_date = $request->input('limit_date');
        $password   = $request->input('password');
 
        //ストレージに保存
        if($request->file('contents')){
            $file_key   = Str::uuid();
            $file_name = $request->file('contents')->getClientOriginalName();
            $size      = $request->file('contents')->getSize();
            Storage::putFileAs('uploads', $request->file('contents'), $file_key);
            $message   = 'アップロードに成功しました';
            $file_url  = config('app.url').'/download/'.$file_key;

            //フォームの内容をDB登録
            $upload = new UploadItem();
            $upload->fill(['file_name' => $file_name,'mail' => $mail,'limit_date' => $limit_date,'password' => $password,'file_key' => $file_key]);
            $upload->save();
            Log::channel('upload')->notice('upload', ['date' => $limit_date, 'mail' => $mail,'file' => $file_name,'file_key' => $file_key ,'size' => $size]);
        }

        return view('upload_result', compact('message', 'file_url'));
    }

}
