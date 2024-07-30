<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UploadItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DeleteFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '期限切れのファイルを削除';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::debug("削除");
        $items = UploadItem::select('file_key', 'file_name')->where('limit_date','<',date('Y-m-d'))->get();
        foreach ($items as $item) {
            Storage::delete('uploads/'.$item->file_key);
            Log::channel('delete')->notice('delete', ['file' => $item->file_name,'file_key' => $item->file_key]);
        }
    }
}
