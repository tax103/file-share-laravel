<?php

namespace App\Http\Controllers;

use App\Models\UploadItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    public function index ($file_key) 
    {
        $error_message = '';
        $password_flg = false;
        $item_count = UploadItem::where('file_key', $file_key)->count();

        //通常はありえないが、取得対象が複数存在した場合もエラーとする
        if($item_count == 1){
            $item = UploadItem::select('file_name', 'limit_date', 'password')
            ->where('file_key', $file_key)->first();

            Log::Debug($item);

            //パスワードがない場合、直接ダウンロード
            if(empty($item->password)){
                return self::download($file_key,$item->file_name);
            }else{
                $password_flg = true;
            }

        }else{
            $error_message = "URLが無効です";
        }

        return view('download', compact('file_key','error_message','password_flg'));
    }

    
    public function check (Request $request) {
        
        $file_key = $request->input('file_key');
        $error_message = '';
        $password_flg = true;

        Log::Debug($request);

        $item_count = UploadItem::where('file_key', $file_key)
        ->where('password', $request->input('password'))
        ->count();
        
        if($item_count == 1){
            $item = UploadItem::select('file_name', 'limit_date')
            ->where('file_key', $file_key)
            ->where('password', $request->input('password'))
            ->first();
            return self::download($file_key,$item->file_name);
        }else{
            $error_message = 'パスワードが間違っています';
        }
        return view('download', compact('file_key','error_message','password_flg'));
    }

    private function download ($file_key,$fileName){
        $filePath = Storage::path('uploads/'.$file_key);
        $mimeType = Storage::mimeType('uploads/'.$file_key);
        $headers = [['Content-Type' => $mimeType]];
        Log::channel('download')->notice('download', ['ip' => $_SERVER['REMOTE_ADDR'],'file' => $fileName,'file_key' => $file_key ]);
        return response()->download($filePath, $fileName, $headers);
    }
}
