<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // $clients = Client::with('user')->get();
        $clients = $request->user()->clients()->get();

        return response()->json($clients);
    }


    public function store(ClientStoreRequest $request)
    {
        $client = $request->user()->clients()->create($request->validated());

        return response()->json([
            'message' => 'Client created successfully.',
            'data' => $client],
        201);
    }


    public function show(Request $request, string $id)
    {
        $client = $request->user()->clients()->findOrFail($id);

        return response()->json($client);
    }


    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->update($request->validated());

        return response()->json([
            'message' => 'Client updated successfully.',
            'data' => $client
        ]);
    }


    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
