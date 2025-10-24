<?php

namespace App\Models\Supplier;

use App\Models\Tool\Tool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact_name',
        'phone',
        'email',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'supplier_id');
    }
}
