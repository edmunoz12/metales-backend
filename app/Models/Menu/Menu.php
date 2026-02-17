<?php

namespace App\Models\Menu;

use App\Models\Submenu\Submenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menus';
    protected $fillable = [
        'menu',
        'icono',
        'order',
        'active',
        'user_id'
    ];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }
}
