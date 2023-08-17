<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function search(Request $request)
    {
        $matches = User::search($request->q ?: '')->paginate();

        return UserResource::collection($matches);
    }
}
