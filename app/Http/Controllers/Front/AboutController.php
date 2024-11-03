<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutEvent;
use App\Models\AboutItem;
use App\Models\AboutTitle;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * [GET] /about
     * 關於我們
     * 
     * @return \Illuminate\View\View 關於我們頁面
     */
    public function list()
    {
        $aboutTitle = AboutTitle::get();
        $item = new AboutItem();
        $about = $item->getList(2);
        $advance = $item->getList(3);
        $event = AboutEvent::get();

        if (!session()->has("bannerAbout")) {
            session()->put("bannerAbout","banner.jpg");
        }

        return view("Front.home.about", compact("aboutTitle", "about", "advance", "event"));
    }
}
