<?php

namespace App\Http\Controllers\Insertion;

use App\Http\Controllers\Controller;
use App\Models\Tool\Tool;
use App\Models\ReportTypes\ReportTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InsertionController extends Controller
{
    // GET /api/tools
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 20);
            $sortColumn = $request->input('sortColumn', 'code');
            $sortDirection = $request->input('sortDirection', 'asc');


            // Columnas permitidas para ordenamiento
            $allowedSortColumns = [
                'id', 'code', 'station_size', 'measurement', 'report_type_id'
            ];

            if (!in_array($sortColumn, $allowedSortColumns)) {
                $sortColumn = 'code';
            }

            $reportTypeMap = [
                'doblado'   => 2,
                'insercion' => 3,
                'inserción' => 3,
            ];

            $searchLower = strtolower($search);
            $reportTypeFilter = $reportTypeMap[$searchLower] ?? null;

            $query = Tool::select(
                'tools.id',
                'tools.code',
                'tools.shape',
                'tools.station_size',
                'tools.measurement',
                'tools.angle',
                'tools.clarity',
                'tools.tool_type_id',
                'tools.supplier_id',
                'suppliers.name as supplier_name',
                'tools.acquired_at',
                'tools.description',
                'tools.model',
                'tools.style',
                'tools.report_type_id',
                'report_types.name as report_type_name',
                'tools.location_id',
            )
                ->leftJoin('suppliers', 'suppliers.id', '=', 'tools.supplier_id')
                ->leftJoin('report_types', 'report_types.id', '=', 'tools.report_type_id')
                ->whereIn('tools.report_type_id', [2, 3]); //doblado e insersion

            // Búsqueda
            if ($reportTypeFilter) {
                // Si escribieron “Doblado” o “Inserción”
                $query->where('report_type_id', $reportTypeFilter);
            } else {
                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('code', 'like', "%$search%")
                            ->orWhere('shape', 'like', "%$search%")
                            ->orWhere('station_size', 'like', "%$search%")
                            ->orWhere('measurement', 'like', "%$search%")
                            ->orWhere('supplier_name', 'like', "%$search%")
                            ->orWhere('model', 'like', "%$search%")
                            ->orWhere('style', 'like', "%$search%")
                            ->orWhere('report_type_id', 'like', "%$search%");
                    });
                }
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

    /**
     * GET /api/tools/{id}
     */
    public function show($id)
    {
        try {
            $tool = Tool::find($id);
            if (!$tool) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La herramienta no existe.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $tool
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al mostrar herramienta', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener la herramienta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/tools
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:3|unique:tools,code',
                'tool_type_id' => 'required|integer|exists:tool_types,id',
                'measurement' => 'required|string|max:255',
                'supplier_id' => 'required|integer|exists:suppliers,id',
                'model' =>'nullable|string|max:250',
                'style' => 'nullable|string|max:250',
                'report_type_id' => 'sometimes|required',
                'acquired_at' => 'required|date',
                'description' => 'nullable|string|max:500',
                'location_id' => 'required|integer|exists:locations,id',

            ]);

            $tool = Tool::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Herramienta creada correctamente.',
                'data' => $tool
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al crear herramienta', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo crear la herramienta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * PUT /api/tools/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $tool = Tool::find($id);
            if (!$tool) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Herramienta no encontrada.'
                ], 404);
            }

            $validated = $request->validate([
                'code' => [
                    'sometimes', 'required', 'string', 'max:3',
                    Rule::unique('tools', 'code')->ignore($tool->id),
                ],
                'tool_type_id' => 'sometimes|required|integer|exists:tool_types,id',
                'measurement' => 'sometimes|required|string|max:255',
                'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
                'model' =>'nullable|string|max:250',
                'style' => 'nullable|string|max:250',
                'report_type_id' => 'sometimes|required',
                'acquired_at' => 'sometimes|required|date',
                'description' => 'nullable|string|max:500',
                'location_id' => 'required|integer|exists:locations,id',
            ]);

            $tool->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Herramienta actualizada correctamente.',
                'data' => $tool
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al actualizar herramienta', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo actualizar la herramienta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE /api/tools/{id}
     */
    public function destroy($id)
    {
        try {
            $tool = Tool::find($id);
            if (!$tool) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Herramienta no encontrada.'
                ], 404);
            }

            $tool->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Herramienta eliminada correctamente.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al eliminar herramienta', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo eliminar la herramienta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
