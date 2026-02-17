<?php

namespace App\Models\UserType;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_types';

    protected $fillable = [
        'name',
        'description',
        'instance',
        'module',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
