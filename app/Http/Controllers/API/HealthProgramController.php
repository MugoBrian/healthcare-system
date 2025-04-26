<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HealthProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HealthProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $healthPrograms = HealthProgram::all();

        return response()->json([
            'success' => true,
            'data' => $healthPrograms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:health_programs',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $healthProgram = HealthProgram::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Health program created successfully',
            'data' => $healthProgram
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(HealthProgram $healthProgram)
    {
        return response()->json([
            'success' => true,
            'data' => $healthProgram
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HealthProgram $healthProgram)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:health_programs,name,' . $healthProgram->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $healthProgram->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Health program updated successfully',
            'data' => $healthProgram
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthProgram $healthProgram)
    {
        $healthProgram->delete();

        return response()->json([
            'success' => true,
            'message' => 'Health program deleted successfully'
        ]);
    }

    /**
     * Get clients enrolled in a specific health program.
     */
    public function getEnrolledClients(HealthProgram $healthProgram)
    {
        $clients = $healthProgram->clients()->with('enrollments')->get();

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }
}
