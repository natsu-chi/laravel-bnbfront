<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuS2 extends Model
{
    protected $table = 'config_menu_s2';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        's1',
        's2_name',
        'seq',
        'active',
        'url',
    ];
}