<?php

namespace App\Models\Submenu;

use App\Models\Menu\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submenu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'submenu',
        'componente',
        'menu_id',
        'orden',
        'icono',
        'active'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
