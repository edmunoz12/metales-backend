<?php

namespace App\Models\ToolType;

use App\Models\Tool\Tool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolType extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'tool_types';
    protected $fillable = [
        'name',
        'description',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    //tipo de herramienta tiene muchas herramientas
    public function tools()
    {
        return $this->hasMany(Tool::class);
    }

}
