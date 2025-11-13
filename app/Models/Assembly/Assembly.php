<?php

namespace App\Models\Assembly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assembly extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'assemblies';

    protected $fillable = [
      'part_number',
      'quantity',
      'priority_type',
      'assembly_date'
    ];
    public const PAGINATE = 20;
    protected $casts = [
        'assembly_date' => 'date',
        'deleted_at' => 'datetime',
    ];

}
