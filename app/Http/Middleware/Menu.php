<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuS1;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 判斷 session 有無 menu
        if (!session()->has('menus')) {
            // 取得選單
            $menus = MenuS1::where('active', 'Y')
            ->with('MenuS2')
            ->get();
        }
        
        // 將選單資料共享給 view
        view()->share('menus', $menus);

        return $next($request);
    }
}
