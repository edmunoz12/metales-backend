<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Tool\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Parámetros recibidos del frontend (Angular)
            $search = $request->input('search', '');
            $page = (int) $request->input('page', 1);
            $pageSize = (int) $request->input('pageSize', 20);
            $sortColumn = $request->input('sortColumn', 't.code');
            $sortDirection = strtolower($request->input('sortDirection', 'asc'));

            // Columnas permitidas para ordenar
            $allowedSortColumns = [
                't.id',
                't.code',
                't.lifecycle_statuses',
                'tt.name',
                'l.name',
                'l.code'
            ];

            if (!in_array($sortColumn, $allowedSortColumns)) {
                $sortColumn = 't.code';
            }

            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            // Construcción de la consulta principal
            $query = DB::table('tools as t')
                ->select(
                    't.id',
                    't.code',
                    't.lifecycle_statuses',
                    'tt.id as tool_type_id',
                    'tt.name as tool_type_name',
                    'l.id as location_id',
                    'l.name as location_name',
                    'l.code as location_code',
                    'l.description as location_description',
                    DB::raw('COUNT(p.id) as process_count') // ejemplo: cuántos procesos usan esa herramienta
                )
                ->leftJoin('locations as l', 't.location_id', '=', 'l.id')
                ->leftJoin('tool_types as tt', 't.tool_type_id', '=', 'tt.id')
                ->leftJoin('processes as p', 't.id', '=', 'p.tool_id')
                ->groupBy(
                    't.id', 't.code', 't.lifecycle_statuses',
                    'tt.id', 'tt.name',
                    'l.id', 'l.name', 'l.code', 'l.description'
                )
                ->orderBy('t.lifecycle_statuses', 'asc');

            // Búsqueda (filtro general)
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('t.code', 'like', "%{$search}%")
                        ->orWhere('tt.name', 'like', "%{$search}%")
                        ->orWhere('l.name', 'like', "%{$search}%")
                        ->orWhere('l.code', 'like', "%{$search}%")
                        ->orWhere('l.description', 'like', "%{$search}%");
                });
            }

            // Ordenamiento y paginación
            $results = $query
                ->orderBy($sortColumn, $sortDirection)
                ->paginate($pageSize, ['*'], 'page', $page);

            // Respuesta JSON uniforme
            return response()->json($results, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al generar el reporte',
                'message' => app()->environment('local') ? $e->getMessage() : 'Error interno del servidor'
            ], 500);
        }
    }

    public function store(Request $request)
    {

    }

    public function show($id) { /* mostrar un report específico */ }

    public function update(Request $request, $id) { /* actualizar un report */ }

    public function destroy($id) { /* eliminar un report */ }
}
