<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutItem extends Model
{
    public $timestamps = false;
    protected $table = "about_item";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "type_id",
        "item_name",
        "content",
        "photo"
    ];

    public function getList($typeId)
    {
        $list = self::where("type_id", $typeId)->get();
        return $list;
    }
}
