<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class ReviewCategories extends Model{
    protected $table = 'review_categories';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
    ];
}