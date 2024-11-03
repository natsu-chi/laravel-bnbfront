<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutEvent extends Model
{
    public $timestamps = false;
    protected $table = "about_event";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "dates",
        "content",
        "create_at"
    ];
}
