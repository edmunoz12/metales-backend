<?php

namespace App\Models\Location;

use App\Models\Tool\Tool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'location_id');
    }
}
