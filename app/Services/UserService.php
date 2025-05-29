<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function show(string $nid): object | null
    {
        $user =  User::select('id', 'name', 'email', 'nid', 'vaccine_status', 'scheduled_date', 'vaccine_center_id')
            ->with('vaccineCenter:id,name')
            ->where('nid', $nid)->first();

        return $user ? new UserResource($user) : null;
    }
}
