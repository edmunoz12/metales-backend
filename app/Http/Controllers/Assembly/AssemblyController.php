<?php

namespace App\Http\Controllers\Assembly;

use App\Events\AssemblyCreated;
use App\Events\AssemblyUpdated;
use App\Http\Controllers\Controller;
use App\Models\Assembly\Assembly;
use App\Models\AssemblyCustomer\AssemblyCustomer;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AssemblyController extends Controller
{
    public function operators()
    {
        return User::select('id', 'name')
            ->where('user_type_id', 5)
            ->get();
    }

    public function customers()
    {
        return AssemblyCustomer::select('id','customer_name','logo_path')->get();
    }

    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 10);

            // Construimos la query base
            $assemblies = Assembly::with('customer')
            ->whereNull('status')
            ->orderBy('priority_type', 'ASC');

            if(!empty($search)){
                $assemblies->where(function($q) use ($search){
                    $q->where('part_number', 'like', "%$search%");
                });
            }

            $results = $assemblies->paginate($pageSize, ['*'], 'page', $page);

            $data = $results->getCollection()->transform(function ($assembly) {
                return [
                    'id' => $assembly->id,
                    'part_number' => $assembly->part_number,
                    'quantity' => $assembly->quantity,
                    'priority_type' => $assembly->priority_type,
                    'assembly_date' => $assembly->assembly_date,
                    'assembly_customer_id' => $assembly->assembly_customer_id,
                    'user_id' => $assembly->user_id,
                    'customer_name' => $assembly->customer ? $assembly->customer->customer_name : null,
                    'logo_url' => $assembly->customer ? asset($assembly->customer->logo_path) : null,
                    'job' => $assembly->job,

                ];
            });

            return response()->json([
                'data' => $data, // $results->items(),
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

    public function reports(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 10);

            // Construimos la query base
            $assemblies = Assembly::query()
                ->where('status', 1)
                ->orderBy('assembly_date', 'DESC');

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
                'assembly_customer_id' => 'required|integer',
                'user_id' => 'required|integer',
                'job' => 'nullable|string',
            ]);

            $assembly = Assembly::create($validated);
            // se dispara evento que muestra los cambios en la tabla en las otras sesiones
            broadcast(new AssemblyCreated($assembly))->toOthers();

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
            Log::error('Error al crear el registro', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'No se generar el registro.',
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
                'assembly_customer_id' => 'required|integer',
                'user_id' => 'required|integer',
                'job' => 'nullable|string',
            ]);

            $assembly->update($validated);
            broadcast(new AssemblyUpdated($assembly))->toOthers();

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
            $assembly->status = 2;
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

    public function complete($id)
    {
        try {
            $assembly = Assembly::findOrFail($id);

            if ($assembly->status === 1) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'El ensamble ya estaba completado'
                ], 200);
            }

            $assembly->status = 1;
            $assembly->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Ensamble marcado como completado.',
                'data' => $assembly
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al completar ensamble', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo completar el ensamble.'
            ], 500);
        }
    }


}

