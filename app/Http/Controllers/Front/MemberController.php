<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberWishlistItem;

class MemberController extends Controller
{
    public function getProfile()
    {
        $member = new Member();
        $memberId = session()->get('memberId');
        $data = $member->getById($memberId);
        return view('Front.member.profile', ['data' => $data]);
    }

    public function updateProfile(Request $req)
    {
        $validatedData = $req->validate([
            'form01_1' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]*$/', // name: 必填，最多 50 字，僅允許英數字和空白
            'form01_2' => 'required|string|email|max:100', // email: 必填，必須符合 email 格式，最多 100 字
        ],[
            'form01_1.required' => '請填寫姓名',
            'form01_1.max' => '姓名最多只能 50 個字',
            'form01_1.regex' => '姓名只能包含英數字和空白',
            'form01_2.required' => '請填寫電子郵件',
            'form01_2.email' => '電子郵件格式不正確',
            'form01_2.max' => '電子郵件最多只能 100 個字',
        ]);
        
        $id = $req->form01_id;
        $name = $validatedData['form01_1'];
        $email = $validatedData['form01_2'];
        $member = Member::find($id);
        try {
            if (empty($member))
            {
                throw new Exception("資料取得失敗", 1);
            }
            
            if ($id != session()->get('memberId'))
            {
                throw new Exception("欄位更新失敗", 1);
            }

            $member->name = $name;
            $member->email = $email;
            $member->save();

            Session::flash('message', '更新成功');
            return redirect('/member/profile');
            
        } catch (\Throwable $th) {
            Session::flash("errorMessage", "更新失敗");
            return back()->withInput()->withErrors(["errorF01" => $th->getMessage()]);
        }
    }

    public function updatePassword(Request $req)
    {
        // 定義驗證規則
        $validatedData = $req->validate([
            'form02_1' => 'required|string', // 舊密碼：必填
            'form02_2' => 'required|string|min:6|max:12', // 新密碼：必填，最少 6 字
        ],[
            'form02_1.required' => '密碼不得空白',
            'form02_2.required' => '密碼不得空白',
            'form02_2.min' => '最少需要 6 個字',
            'form02_2.max' => '最多只能 12 個字',
        ]);

        $id = $req->form02_id;
        $pwd = $validatedData['form02_1'];
        $newPwd = $validatedData['form02_2'];
        $member = Member::find($id);
        try {
            if (empty($member))
            {
                throw new Exception("資料取得失敗", 1);
            }
            
            if ($id != session()->get('memberId'))
            {
                throw new Exception("欄位更新失敗", 1);
            }

            $isValid = $member->validatePassword($pwd);
            if (!$isValid)
            {
                throw new Exception("密碼錯誤", 1);
            } else {
                $member->encryptPassword($newPwd);
                $member->save();
            }

            Session::flash('message', '更新成功');
            return redirect('/member/profile');
            
        } catch (\Throwable $th) {
            Session::flash("errorMessage", "更新失敗");
            return back()->withInput()->withErrors(["errorF02" => $th->getMessage()]);
        }
    }

    public function listWishlistItem()
    {
        if (!session()->get('memberId')) {
            return response()->json(['error' => '無效查詢請求'], 400);
        }
        $mwiList = MemberWishlistItem::select('member_wishlist_item.*', 'listing.*')
                                     ->join('listing', 'member_wishlist_item.listing_id', '=', 'listing.id')
                                     ->where('member_wishlist_item.created_by', session()->get('memberId'))
                                     ->where('member_wishlist_item.active', 'Y')
                                     ->get();
        if ($mwiList->isNotEmpty()) {
            return view('Front.member.wishlist', ['list' => $mwiList]);
        }
    }

    public function addWishlistItem(Request $req)
    {
        $listingId = $req->listing_id;
        $id = session()->get('memberId');

        $member = (new Member)->getById($id);
        if (empty($member)) {
            Session::flash("errorMessage", "收藏失敗");
            return response()->json(['error' => '加入清單失敗'], 400);
        }

        $mwi = MemberWishlistItem::where('created_by', $member->id)
                                 ->where('listing_id', $listingId)
                                 ->first();
        
        if (empty($mwi)) {
            $mwi = new MemberWishlistItem();
            $mwi->created_by = $id;
            $mwi->listing_id = $listingId;
            $mwi->active = 'Y';
            $result = $mwi->save();
        } else {
            $mwi->active = 'Y';
            $result = $mwi->save();
        }

        if ($result) {
            return response()->json(['msg' => '加入成功'], 200);
        } else {
            return response()->json(['error' => '加入清單失敗'], 404);
        }
    }

    public function deleteWishlistItem(Request $req)
    {
        $listingId = $req->listing_id;

        $member = (new Member)->getById(session()->get('memberId'));
        if (empty($member)) {
            Session::flash("errorMessage", "收藏失敗");
            response()->json(['error' => '移除清單失敗'], 400);
        }

        $mwi = MemberWishlistItem::where('created_by', $member->id)
                                 ->where('listing_id', $listingId)
                                 ->first();

        if (isset($mwi)) {
            $mwi->active = '';
            $mwi->updated_at = now();
            $result = $mwi->save();
            if ($result) {
                return response()->json(['msg' => '移除成功'], 200);
                exit;
            }
        }
        
        return response()->json(['error' => '移除清單失敗'], 404);
    }
}
