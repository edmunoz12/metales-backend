<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Location\Location;
use App\Models\Supplier\Supplier;
use App\Models\Tool\Tool;
use App\Models\ToolType\ToolType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ToolsController extends Controller
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
                'id', 'code', 'shape', 'station_size', 'measurement', 'angle', 'clarity','lifecycle_statuses'
            ];

            if (!in_array($sortColumn, $allowedSortColumns)) {
                $sortColumn = 'code';
            }

            $query = Tool::select(
                'id',
                'code',
                'lifecycle_statuses',
                'shape',
                'station_size',
                'measurement',
                'angle',
                'clarity',
                'tool_type_id',
                'location_id',
                'supplier_id',
                'acquired_at',
                'description',
                'report_type_id'
            )->where('report_type_id', 1);

            // Búsqueda
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%$search%")
                        ->orWhere('shape', 'like', "%$search%")
                        ->orWhere('station_size', 'like', "%$search%")
                        ->orWhere('measurement', 'like', "%$search%")
                        ->orWhere('angle', 'like', "%$search%")
                        ->orWhere('clarity', 'like', "%$search%")
                        ->orWhere('lifecycle_statuses', 'like', "%$search%");
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
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:3|unique:tools,code',
                'shape' => 'required|string|max:255',
                'station_size' => 'required|string|max:255',
                'measurement' => 'required|string|max:255',
                'angle' => 'required|integer',
                'clarity' => 'required|string|max:255',
                'tool_type_id' => 'required|integer|exists:tool_types,id',
                'location_id' => 'required|integer|exists:locations,id',
                'supplier_id' => 'required|integer|exists:suppliers,id',
                'lifecycle_statuses' => 'required|integer|max:255',
                'acquired_at' => 'required|date',
                'description' => 'nullable|string|max:500',
                'report_type_id' => 'sometimes|required',
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
                'shape' => 'sometimes|required|string|max:255',
                'station_size' => 'sometimes|required|string|max:255',
                'measurement' => 'sometimes|required|string|max:255',
                'angle' => 'sometimes|required|integer|max:255',
                'clarity' => 'sometimes|required|string|max:255',
                'tool_type_id' => 'sometimes|required|integer|exists:tool_types,id',
                'location_id' => 'sometimes|required|integer|exists:locations,id',
                'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
                'lifecycle_statuses' => 'sometimes|required|integer|max:255',
                'acquired_at' => 'sometimes|required|date',
                'description' => 'nullable|string|max:500',
                'report_type_id' => 'sometimes|required',
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


    public function toolTypes()
    {
        return ToolType::select('id', 'name')->get();
    }

    public function locations() {
        return Location::select('id', 'name', 'code')->get();
    }

    public function suppliers() {
        return Supplier::select('id', 'name')->get();
    }

    public function count() {
        $count = Tool::count();
        return response()->json(['count' => $count]);
    }

}

