<?php

namespace App\Services\ToolService;

use App\Models\Tool\Tool;
use App\Models\ToolCode\ToolCode;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function execute(array $data): Tool
    {
        return DB::transaction(function () use ($data) {

            /*
            |--------------------------------------------------------------------------
            | 1. TOMAR CODE DISPONIBLE (LOCK)
            |--------------------------------------------------------------------------
            */

            $toolCode = ToolCode::takeAvailable();

            /*
            |--------------------------------------------------------------------------
            | 2. CREAR TOOL
            |--------------------------------------------------------------------------
            */

            $tool = Tool::create([
                'tool_type_id'        => $data['tool_type_id'],
                'location_id'         => $data['location_id'],
                'supplier_id'         => $data['supplier_id'],
                'lifecycle_statuses'  => $data['lifecycle_statuses'],
                'acquired_at'         => $data['acquired_at'],
                'description'         => $data['description'] ?? null,
                'shape'               => $data['shape'],
                'station_size'        => $data['station_size'],
                'measurement'         => $data['measurement'],
                'angle'               => $data['angle'],
                'clarity'             => $data['clarity'],
                'model'               => $data['model'] ?? null,
                'style'               => $data['style'] ?? null,
                'report_type_id'      => $data['report_type_id'],

                /*
                |--------------------------------------------------------------------------
                | CAMPOS DEL SISTEMA (NO DEL USUARIO)
                |--------------------------------------------------------------------------
                */

                'tool_code_id'        => $toolCode->id,
                'code'                => $toolCode->code,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 3. ASIGNAR CODE
            |--------------------------------------------------------------------------
            */

            $toolCode->assignTo($tool);

            return $tool;
        });
    }


}
