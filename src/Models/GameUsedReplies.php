<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class GameUsedReplies extends Model{
    protected $table = 'game_used_replies';
    public $timestamps = true;

    protected $fillable = [
        'game_id',
        'used_reply_id',
    ];
}