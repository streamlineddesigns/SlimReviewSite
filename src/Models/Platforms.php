<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Platforms extends Model{
    protected $table = 'platforms';
    public $timestamps = true;

    protected $fillable = [
        'name',
    ];
}