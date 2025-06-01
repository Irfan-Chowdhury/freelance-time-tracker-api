<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Cache;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $clients = Cache::remember('user_'.$request->user()->id.'_clients', now()->addMinutes(30), function () use ($request) {
                return $request->user()->clients()->get();
            });

            return ClientResource::collection($clients);

        } catch (Exception $e) {

            return self::errorInfo($e->getMessage());
        }
    }

    public function store(ClientStoreRequest $request)
    {
        try {
            $client = $request->user()->clients()->create($request->validated());

            return (new ClientResource($client))->additional([
                'message' => 'Client created successfully.',
            ]);

        } catch (Exception $e) {

            return self::errorInfo($e->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        $client = $request->user()->clients()->findOrFail($id);

        return new ClientResource($client);
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {
        try {
            $client->update($request->validated());

            return (new ClientResource($client))->additional([
                'message' => 'Client updated successfully.',
            ]);

        } catch (Exception $e) {

            return self::errorInfo($e->getMessage());
        }
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully.']);
    }

    private function errorInfo($errorMessage)
    {
        Log::error('Failed to create time log: '.$errorMessage);

        return response()->json([
            'message' => 'Something went wrong while creating time log.',
            'error' => $errorMessage,
        ], 500);
    }
}
