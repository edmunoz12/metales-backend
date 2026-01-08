<?php

namespace App\Models\Assembly;

use App\Models\AssemblyCustomer\AssemblyCustomer;
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
      'assembly_date',
      'assembly_customer_id',
      'user_id',
      'job'
    ];
    public const PAGINATE = 20;
    protected $casts = [
        'assembly_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(AssemblyCustomer::class, 'assembly_customer_id');
    }

}
