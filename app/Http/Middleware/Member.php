<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Member
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty(session()->get("memberId")))
        {
            return redirect("/login");
            exit;
        }

        // 檢查 cookie 中的 session ID
        if ($request->hasCookie('session_id')) {
            $sessionId = $request->cookie('session_id');

            // 驗證 session ID 的有效性
            if (session()->getId() === $sessionId) {
                return redirect("/login");
            }
            
        }
        
        return $next($request);
    }
}
