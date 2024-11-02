<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Listing;
use App\Models\ListingComment;
use App\Models\ListingReview;
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

    public function getByUrl(Request $req)
    {
        $url = $req->query('url');

        // 驗證網址格式
        if (!preg_match("/^https:\/\/www\.airbnb\.com\/rooms\//", $url)) {
            return back()->withInput()->withErrors(["error" => "輸入格式錯誤"]);
            exit;
        }

        // 擷取網址 id，以進行查詢
        $id = str_replace('https://www.airbnb.com/rooms/', '', $url);
        return redirect('/properties/'.$id);
    }

    public function getById(Request $req)
    {
        $id = $req->id;
        $data = Listing::where('id', $id)
                       ->first();
        if (empty($data)) {
            return view('Front.properties.detail', ['data' => null]);
            exit;
        }

        // 根據 id，取得評論資料
        $comments = ListingComment::where('listing_id', $id)
                                  ->get();

        // 根據 id，取得評論分數
        $review = ListingReview::where('id', $id)
                               ->first();
                              
        // 根據 listing 的 city_id，取得城市詳細資料
        $city = (new City())->getDetailById($data->city_id);
        if (empty($city)) {
            return view('Front.properties.detail', ['data' => null]);
            exit;
        }
        return view('Front.properties.detail', ['data' => $data, 'cityInfo' => $city, 'comments' => $comments, 'review' => $review]);
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
