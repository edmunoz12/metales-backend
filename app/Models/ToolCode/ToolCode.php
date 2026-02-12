<?php

namespace App\Models\ToolCode;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tool\Tool;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tool_codes';

    const AVAILABLE = 0;
    const ASSIGNED  = 1;

    protected $fillable = [
        'code',
        'tool_id',
        'status',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function takeAvailable(): self
    {
        return self::where('status', self::AVAILABLE)
            ->whereNull('tool_id')
            ->orderBy('id')
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function assignTo(Tool $tool): void
    {
        $this->update([
            'tool_id' => $tool->id,
            'status' => self::ASSIGNED,
        ]);
    }

    public function release(): void
    {
        $this->update([
            'tool_id' => null,
            'status' => self::AVAILABLE,
        ]);
    }

    public function tool() {
        return $this->hasOne(Tool::class);
    }


}
