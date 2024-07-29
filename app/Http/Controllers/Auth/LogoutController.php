<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LogoutController extends Controller
{
    public function __invoke(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return Response::json(['message' => 'Logged out successfully'], 200);
    }
}
