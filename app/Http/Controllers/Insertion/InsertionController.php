<?php

namespace App\Http\Controllers\Insertion;

use App\Http\Controllers\Controller;
use App\Models\Tool\Tool;
use Illuminate\Http\Request;

class InsertionController extends Controller
{
    // GET /api/tools
    public function index(Request $request)
    {
        try {
            $reportTypeId = 3;
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 20);
            $sortColumn = $request->input('sortColumn', 'code');
            $sortDirection = $request->input('sortDirection', 'asc');


            // Columnas permitidas para ordenamiento
            $allowedSortColumns = [
                'id', 'code', 'shape', 'station_size', 'measurement', 'angle', 'clarity'
            ];

            if (!in_array($sortColumn, $allowedSortColumns)) {
                $sortColumn = 'code';
            }

            $query = Tool::select(
                'id',
                'code',
                'shape',
                'station_size',
                'measurement',
                'angle',
                'clarity',
                'tool_type_id',
                'location_id',
                'supplier_id',
                'acquired_at',
                'description'
            )->where('report_type_id', $reportTypeId);

            // Búsqueda
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%$search%")
                        ->orWhere('shape', 'like', "%$search%")
                        ->orWhere('station_size', 'like', "%$search%")
                        ->orWhere('measurement', 'like', "%$search%")
                        ->orWhere('angle', 'like', "%$search%")
                        ->orWhere('clarity', 'like', "%$search%");
                });
            }

            // Orden y paginación
            $results = $query->orderBy($sortColumn, $sortDirection)
                ->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'data' => $results->items(),
                'total' => $results->total(),
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al realizar la consulta',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
