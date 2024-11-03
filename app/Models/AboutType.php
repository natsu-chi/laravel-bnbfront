<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AboutType extends Model
{
    public $timestamps = false;
    protected $table = "about_type";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "title",
        "items"
    ];

    public function getList()
    {
        $list = DB::table("about_type")
                  ->selectRaw("*")
                  ->whereNotIn("id", function($query){
                      $query->select("type_id")->from("about_title");
                  })->get();
        
        return $list;
    }
}
