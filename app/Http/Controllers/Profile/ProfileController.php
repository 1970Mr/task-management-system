<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{
    public function userProfile(Request $request): JsonResponse
    {
        return Response::json($request->user());
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $this->getValidData($request);
        $user->update($data);
        return Response::json($user);
    }

    private function getValidData(UpdateProfileRequest $request): array
    {
        $data = $request->validated();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }
        return $data;
    }
}
