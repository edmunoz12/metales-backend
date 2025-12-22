<?php

namespace App\Models\AssemblyCustomer;

use App\Models\Assembly\Assembly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssemblyCustomer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'assembly_customers';

    protected $fillable = [
        'customer_name',
        'certifications',
        'logo_path'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function assemblies()
    {
        return $this->hasMany(Assembly::class, 'assembly_customer_id');
    }
}
