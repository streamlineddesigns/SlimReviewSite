<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class ReviewCategoryUsedReplies extends Model{
    protected $table = 'review_category_used_replies';
    public $timestamps = true;

    protected $fillable = [
        'review_category_id',
        'used_reply_id',
    ];
}