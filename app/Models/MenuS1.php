<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuS2;

class MenuS1 extends Model
{
    protected $table = 'config_menu_s1';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        's1_name',
        'seq',
        'active',
        'types',
        'url',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function MenuS2()
    {
        return $this->hasMany(MenuS2::class, 's1', 'id');
    }
}