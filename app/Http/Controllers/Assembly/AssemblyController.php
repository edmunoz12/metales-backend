<?php

namespace App\Http\Controllers\Assembly;

use App\Http\Controllers\Controller;
use App\Models\Assembly\Assembly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AssemblyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 20);

            // Construimos la query base
            $assemblies = Assembly::query()
                ->orderBy('priority_type', 'ASC');

            if(!empty($search)){
                $assemblies->where(function($q) use ($search){
                    $q->where('part_number', 'like', "%$search%");
                });
            }

            $results = $assemblies->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'data' => $results->items(),
                'total' => $results->total(),
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'index, Error al realizar la consulta',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $assembly = Assembly::find($id);
            if(!$assembly){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ensabmble no encontrado.'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $assembly
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

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'part_number' => 'required|string|max:20',
                'quantity' => 'required|integer',
                'priority_type' => 'required|integer',
                'assembly_date' => 'required|date',
            ]);

            $assembly = Assembly::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Herramienta creada correctamente.',
                'data' => $assembly
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

    public function update(Request $request, $id)
    {
        try {
            $assembly = Assembly::findOrFail($id);

            $validated = $request->validate([
                'part_number' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'priority_type' => 'required|integer',
                'assembly_date' => 'nullable|date',
            ]);

            $assembly->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Ensamble actualizado correctamente.',
                'data' => $assembly
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al actualizar ensamble', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo actualizar la ensamble.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $assembly = Assembly::findOrFail($id);
            $assembly->delete();

            return response()->json(['message' => 'Ensamble eliminado correctamente.'], 200);

        } catch (\Exception $e) {
            Log::error('Error al eliminar ensamble', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo eliminar la ensamble.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

