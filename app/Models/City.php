<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'short_name',
        'region_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'date',
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class, 'city_id');
    }

    public function listingsWithAccommodates($minAccommodates = 2)
    {
        return $this->listings()
        ->where('accommodates', '>=', $minAccommodates)
        ->orderBy('neighbourhood_cleansed')
        ->get();
    }

    public function listingsWithAccommodatesByPage($minAccommodates = 2, $perPage = 10)
    {
        return $this->listings()
        ->where('accommodates', '>=', $minAccommodates)
        ->orderBy('neighbourhood_cleansed')
        ->paginate($perPage);
    }
}
