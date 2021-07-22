<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class ReplyReviewCategories extends Model{
    protected $table = 'reply_review_categories';
    public $timestamps = true;

    protected $fillable = [
        'reply_id',
        'review_category_id',
    ];
}