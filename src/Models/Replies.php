<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Replies extends Model{
    protected $table = 'replies';
    public $timestamps = true;

    protected $fillable = [
        'text',
    ];
}