<?php

namespace App\Models\Tool;

use App\Models\Location\Location;
use App\Models\Process\Process;
use App\Models\Supplier\Supplier;
use App\Models\ToolType\ToolType;
use App\Models\ReportTypes\ReportTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ToolCode\ToolCode;

class Tool extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tools';
    protected $fillable = [
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
        'model',
        'style',
        'report_type_id',
        'tool_code_id',
        'code',
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

    public function reportType()
    {
        return $this->belongsTo(ReportTypes::class, 'report_type_id');
    }

    public function toolCode() {
        return $this->belongsTo(ToolCode::class);
    }

}
