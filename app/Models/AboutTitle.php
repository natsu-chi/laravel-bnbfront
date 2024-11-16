<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AboutTitle extends Model
{
    public $timestamps = false;
    protected $table = "about_title";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "lan",
        "type_id",
        "title",
        "content"
    ];

    public function getList()
    {
        $list = DB::table("about_title AS a")
                  ->selectRaw("a.*, b.title AS type_name")
                  ->join("about_type AS b", "a.type_id", "b.id")
                  ->get();

        return $list;
    }
}
