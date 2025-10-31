<?php

namespace App\Models\Tool;

use App\Models\Location\Location;
use App\Models\Process\Process;
use App\Models\Supplier\Supplier;
use App\Models\ToolType\ToolType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tools';
    protected $fillable = [

        'code',
        'tool_type_id',
        'location_id',
        'supplier_id',
        'lifecycle_statuses',
        'acquired_at',
        'description',
        'shape',
        'station_size',
        'measurement',
        'angle',
        'clarity',
        'report_type_id',
    ];

    public const PAGINATE = 50;
    protected $casts = [
        'acquired_at' => 'date',
        'angle' => 'double',
        'deleted_at' => 'datetime',
    ];

    // Una herramienta pertenece a un tipo de herramient
    public function toolType()
    {
        return $this->belongsTo(ToolType::class, 'tool_type_id');
    }

    // Una herramienta pertenece a una ubicación
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Una herramienta pertenece a un proveedor
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'process_tool')
            ->withTimestamps();
    }

}
