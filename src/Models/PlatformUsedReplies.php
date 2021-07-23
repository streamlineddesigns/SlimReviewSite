<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class PlatformUsedReplies extends Model{
    protected $table = 'platform_used_replies';
    public $timestamps = true;

    protected $fillable = [
        'platform_id',
        'used_reply_id',
    ];
}