<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $this->authenticate($request);
            $user = User::query()->where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            return Response::json(['access_token' => $token, 'token_type' => 'Bearer'], 200);
        } catch (AuthenticationException $e) {
            return Response::json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * @throws AuthenticationException
     */
    private function authenticate(LoginRequest $request): void
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('Invalid login details');
        }
    }
}
