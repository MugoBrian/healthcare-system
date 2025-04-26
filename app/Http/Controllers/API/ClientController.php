<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients)
        ]);
    }

    /**
     * Search for clients.
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $clients = Client::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('national_id', 'like', "%{$query}%")
            ->get();

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'national_id' => 'nullable|string|max:30|unique:clients',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Client registered successfully',
            'data' => new ClientResource($client)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load('healthPrograms');

        return response()->json([
            'success' => true,
            'data' => new ClientResource($client)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'date_of_birth' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'national_id' => 'nullable|string|max:30|unique:clients,national_id,' . $client->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $client->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully',
            'data' => new ClientResource($client)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted successfully'
        ]);
    }

    /**
     * Get health programs the client is enrolled in.
     */
    public function getEnrolledPrograms(Client $client)
    {
        $client->load('healthPrograms');

        return response()->json([
            'success' => true,
            'data' => new ClientResource($client)
        ]);
    }
}
