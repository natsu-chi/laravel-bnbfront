<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingComment extends Model
{
    protected $table = 'listing_comment';

    protected $fillable = [
        'listing_id',
        'reviewer_id',
        'comments',
        'date',
        'reviewer_name',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}