<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Enrollment;
use App\Models\HealthProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['client', 'healthProgram'])->get();

        return response()->json([
            'success' => true,
            'data' => $enrollments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'health_program_id' => 'required|exists:health_programs,id',
            'enrollment_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:enrollment_date',
            'status' => 'required|in:active,completed,withdrawn',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if client is already enrolled in this program with active status
        $existingEnrollment = Enrollment::where('client_id', $request->client_id)
            ->where('health_program_id', $request->health_program_id)
            ->where('status', 'active')
            ->first();

        if ($existingEnrollment && $request->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Client is already enrolled in this program',
            ], 422);
        }

        $enrollment = Enrollment::create($request->all());
        $enrollment->load(['client', 'healthProgram']);

        return response()->json([
            'success' => true,
            'message' => 'Client enrolled successfully',
            'data' => $enrollment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['client', 'healthProgram']);

        return response()->json([
            'success' => true,
            'data' => $enrollment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'enrollment_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date|after_or_equal:enrollment_date',
            'status' => 'sometimes|required|in:active,completed,withdrawn',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment->update($request->all());
        $enrollment->load(['client', 'healthProgram']);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully',
            'data' => $enrollment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully'
        ]);
    }

    /**
     * Enroll a client in multiple health programs.
     */
    public function enrollClientInPrograms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'programs' => 'required|array',
            'programs.*.health_program_id' => 'required|exists:health_programs,id',
            'programs.*.enrollment_date' => 'required|date',
            'programs.*.status' => 'required|in:active,completed,withdrawn',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::findOrFail($request->client_id);
        $enrollments = [];

        foreach ($request->programs as $program) {
            // Check if client is already enrolled in this program with active status
            $existingEnrollment = Enrollment::where('client_id', $client->id)
                ->where('health_program_id', $program['health_program_id'])
                ->where('status', 'active')
                ->first();

            if ($existingEnrollment && $program['status'] === 'active') {
                continue; // Skip this program if already enrolled
            }

            $enrollment = Enrollment::create([
                'client_id' => $client->id,
                'health_program_id' => $program['health_program_id'],
                'enrollment_date' => $program['enrollment_date'],
                'end_date' => $program['end_date'] ?? null,
                'status' => $program['status'],
                'notes' => $program['notes'] ?? null,
            ]);

            $enrollment->load(['client', 'healthProgram']);
            $enrollments[] = $enrollment;
        }

        return response()->json([
            'success' => true,
            'message' => 'Client enrolled in programs successfully',
            'data' => $enrollments
        ], 201);
    }

    /**
     * Get all programs a client is enrolled in
     */
    public function getClientPrograms(Client $client)
    {
        $enrollments = Enrollment::with('healthProgram')
            ->where('client_id', $client->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $enrollments
        ]);
    }

    /**
     * Get all clients enrolled in a specific program
     */
    public function getProgramClients(HealthProgram $healthProgram)
    {
        $enrollments = Enrollment::with('client')
            ->where('health_program_id', $healthProgram->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $enrollments
        ]);
    }
}
