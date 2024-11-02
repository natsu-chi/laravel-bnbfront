<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * 404 錯誤頁面
     * 
     * @return \Illuminate\View\View
     */
    public function notFound()
    {
        return response()->view('Front.errors.404', [], 404);
    }

    /**
     * 400 錯誤頁面
     * 
     * @return \Illuminate\View\View
     */
    public function badRequest()
    {
        return response()->view('Front.errors.400', [], 400);
    }

    /**
     * 500 錯誤頁面
     * 
     * @return \Illuminate\View\View
     */
    public function serverError()
    {
        return response()->view('Front.errors.500', [], 500);
    }
}
