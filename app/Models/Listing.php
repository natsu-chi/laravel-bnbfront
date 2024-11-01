<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'listing';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'bigint';
    protected $fillable = [
        'id',
        'name',
        'description',
        'listing_url',
        'picture_url',
        'latitude',
        'longitude',
        'city_id',
        'neighbourhood_cleansed',
        'property_type',
        'room_type',
        'host_id',
        'bathrooms_text',
        'bedrooms',
        'beds',
        'amenities',
        'accommodates',
        'price',
        'has_availability',
        'instant_bookable',
        'last_scraped',
    ];

    // 定義屬性轉換
    protected $casts = [
        'latitude' => 'decimal:15',
        'longitude' => 'decimal:15',
        'bedrooms' => 'double',
        'beds' => 'double',
        'price' => 'decimal:2',
        'last_scraped' => 'date',
        'has_availability' => 'boolean',
        'instant_bookable' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
