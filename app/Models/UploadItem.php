<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadItem extends Model
{
    use HasFactory;
    protected $table = 'upload_items';

    protected $fillable = [
        'file_name', 'mail', 'limit_date' , 'password' ,'file_key'
    ];

    protected $guarded = [
        'id',
    ];
}
