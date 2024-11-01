<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function listByQueries(Request $req)
    {
        $location = $req->query('location');
        $checkin = $req->query('checkin');
        $checkout = $req->query('checkout');
        $adults = $req->query('adults');
        $page = $req->query('page');
        
        $city = City::where('name', ucfirst($location))
                    ->where('active', 'Y')
                    ->first();
        if (empty($city)) {
            return response()->json(['error' => '找不到城市相關資料'], 404);
            exit;
        }
        $cityName = ucfirst($location); 

        // 取得城市的 listing 列表
        $listings = $city->listingsWithAccommodates($adults);
        return view('Front.properties.search', ['list' => $listings, 'cityName' => $cityName]);
    }

    public function listByCity(Request $req)
    {
        $city = City::where('name', ucfirst($req->location))
                    ->where('active', 'Y')
                    ->first();
        if (empty($city)) {
            return response()->json(['error' => '找不到城市相關資料'], 404);
            exit;
        }

        $cityName = ucfirst($req->location);

        // 取得城市的 listing 列表 (accommodates >= 2 的列表，每頁顯示 10 筆)
        $listings = $city->listingsWithAccommodates(2, 10);
        
        return view('Front.properties.cityGraph', ['list' => $listings, 'cityName' => $cityName]);
    }
}
