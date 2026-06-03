<?php

namespace App\Models\Assembly;

use App\Models\AssemblyCustomer\AssemblyCustomer;
use App\Models\User\User;
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
      'created_by',
      'job',
      'status',
      'retention'
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


    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
