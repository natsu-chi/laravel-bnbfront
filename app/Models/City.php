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

    public function getDetailById($id)
    {
        /**
         * select 
         * a.id as city_id, a.name as city_name,
         * b.id as region_id, b.name as region_name, b.short_name as region_short_name
         * c.id as country_id, c.name as country_name , c.short_name as country_short_name
         * from city a
         * join region b on a.region_id = b.id
         * join country c on b.id = c.id
         * where a.id = :id and active = 'Y'
         * limit 1;
         */
        $data = self::join("region", "city.region_id", "=", "region.id")
            ->join("country", "region.country_id", "=", "country.id")
            ->select("city.id", "city.name", "city.short_name", "country.name as country_name", "region.name as region_name", "country.short_name as country_short_name", "region.short_name as region_short_name")
            ->where("city.id", $id)
            ->where("city.active", 'Y')
            ->first();
        return $data;
    }

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
