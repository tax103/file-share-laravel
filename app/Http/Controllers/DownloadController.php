<?php

namespace App\Http\Controllers;

use App\Models\UploadItem;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index ($file_key) 
    {

        $error_message = '';

        
        $item_count = UploadItem::where('file_key', $file_key)->count();

        //通常はありえないが、取得対象が複数存在した場合もエラーとする
        if($item_count == 1){
            $item = UploadItem::select('file_name', 'limit_date', 'password')
            ->where('file_key', $file_key)->get();
            //パスワードがない場合、直接ダウンロード
            if(empty($item->password)){
                download($file_key,$item->file_name)
            }

        }else{
            $error_message = "ファイルが存在しません";
        }


        return view('download', compact('file_key','error_message'));
    }

    private function download ($file_key,$fileName){
        $filePath = Storage::path('downloads/'.$file_key);
        $mimeType = Storage::mimeType('downloads/'.$file_key);
        $headers = [['Content-Type' => $mimeType]];
        return response()->download($filePath, $fileName, $headers);
    }
}
