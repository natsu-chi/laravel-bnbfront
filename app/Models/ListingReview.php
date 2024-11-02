<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingReview extends Model
{
    protected $table = 'listing_review';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'bigint';
    protected $fillable = [
        'number_of_reviews_ltm',        // 最近12個月評價數
        'number_of_reviews_l30d',       // 最近30天評價數
        'reviews_per_month',            // 每月評價數量
        'review_scores_rating',         // 評價分數
        'review_scores_accuracy',       // 準確性評價
        'review_scores_cleanliness',    // 清潔度評價
        'review_scores_checkin',        // 入住評價
        'review_scores_communication',  // 溝通評價
        'review_scores_location',       // 地點評價
        'review_scores_value',          // 價值評價
        'first_review',                 // 最早評論時間
        'last_review',                  // 最新評論時間
    ];

    protected $dates = [
        'first_review',
        'last_review',
    ];
}
