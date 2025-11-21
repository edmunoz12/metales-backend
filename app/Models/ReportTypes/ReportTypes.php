<?php

namespace App\Models\ReportTypes;

use App\Models\Tool\Tool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTypes extends Model
{
    use HasFactory;
    protected $table = 'report_types';
    protected $fillable = ['name','code','description'];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'report_type_id');
    }

}
