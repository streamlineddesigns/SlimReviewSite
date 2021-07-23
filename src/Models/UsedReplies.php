<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class UsedReplies extends Model{
    protected $table = 'used_replies';
    public $timestamps = true;

    protected $fillable = [
        'reply_id',
    ];
}