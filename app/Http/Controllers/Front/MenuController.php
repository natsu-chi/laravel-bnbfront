<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuS1;

class MenuController extends Controller
{
    public function index()
    {
        $menus = MenuS1::where('active', 'Y')
                       ->with('MenuS2')
                       ->get();
        dd($menus);
        return view('your-view-file', compact('menus'));
    }
}
