<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberWishlistItem extends Model
{
    protected $table = 'member_wishlist_item';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'listing_id',
        'active',
        'created_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}