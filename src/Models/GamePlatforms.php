<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class GamePlatforms extends Model{
    protected $table = 'game_platforms';
    public $timestamps = true;

    protected $fillable = [
        'game_id',
        'platform_id',
    ];
}