<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Member extends Model
{
    public $timestamps = false;
    protected $table = "member";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "username", // 用戶自行命名 ID
        "name",     // 用戶名稱
        "email",
        "password",
        "active",
        "created_at"
    ];

    public function getMember($username, $password)
    {
        echo $username;
        echo $password;
        $member = Member::where('username', $username)->first();
        if(!isset($member)) {
            return null;
        }
        if (!Hash::check($password, $member->password) )
        {
            return null;
        } else
        {
            return $member;
        }
    }

    public function getById($id)
    {
        $member = self::where("id", $id)->where("active", "Y")->first();
        return $member;
    }

    public function encryptPassword($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function validatePassword($password)
    {
        return Hash::check($password, $this->attributes['password']);
    }
}
