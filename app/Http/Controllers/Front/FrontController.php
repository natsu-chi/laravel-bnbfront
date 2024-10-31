<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    /**
     * [GET] /
     * 首頁
     * 
     * @return \Illuminate\View\View 首頁
     */
    public function home() {
        return view('Front.home.home');
    }
    /**
     * [GET] /login
     * 會員登入頁面
     * 
     * @return \Illuminate\View\View 登入頁面
     */
    public function login() {

        // 如果偵測到 session 紀錄，就移除登入相關紀錄
        if (session()->has('username') || session()->has('memberId')) {
            session()->forget('username');
            session()->forget('memberId');
            session()->save();
        }
        
        return view('Front.home.login')->withCookie(cookie("session_id", null, -1));;
    }

    /**
     * [POST] /login
     * 處理登入請求
     * 
     * @param \Illuminate\Http\Request $req 包含會員帳號、密碼和驗證碼
     * @return \Illuminate\Http\RedirectResponse 返回登入頁面或導向首頁
     */
    public function doLogin(Request $req) {

        // 檢查驗證碼
        if (captcha_check($req->code) == false)
        {
            return back()->withInput()->withErrors(["code" => "驗證碼錯誤"]);
            exit;
        }

        // 檢查帳號密碼
        $member = (new Member())->getMember($req->username, $req->pwd);

        if (empty($member))
        {
            return back()->withInput()->withErrors(["error" => "帳號或密碼錯誤"]);
            exit;
        }

        // 新增 session
        session()->put("username", $member->username); // 使用者名稱
        session()->put("memberId", $member->id);       // 使用者 ID
        session()->save();

        // 如果勾選「記住我」，將 session ID 存入 cookie
        if ($req->filled("rememberMe")) {
            $cookie = cookie("session_id", session()->getId(), 43200);
            return redirect("/")->withCookie($cookie);
        }

        return redirect("/");

    }

    /**
     * [GET] /signup
     * 會員註冊頁面
     * 
     * @return \Illuminate\View\View 註冊頁面
     */
    public function signup() {
        return view('Front.home.signup');
    }

    /**
     * [POST] /signup
     * 處理註冊請求
     * 
     * @param \Illuminate\Http\Request $req 包含會員 email、密碼和驗證碼
     * @return \Illuminate\Http\RedirectResponse 返回登入頁面或導向首頁
     */
    public function doSignup(Request $req) {
        $member = new Member();
        $member->email = $req->email;
        $member->username = $req->username;
        $member->password = bcrypt($req->pwd);

        $result = $member->save();

        if($result) {
            Session::flash("message", "註冊成功");
            return redirect("/");
        } else {
            return back()->withInput()->withErrors(["error" => "註冊失敗"]);
            exit;
        }
    }

    /**
     * [GET] /logout
     * 會員登出
     * 
     * @return \Illuminate\Http\RedirectResponse 導向首頁
     */
    public function logout() {
        session()->forget('username');
        session()->forget('memberId');
        session()->save();
        return redirect("/");
    }
}
