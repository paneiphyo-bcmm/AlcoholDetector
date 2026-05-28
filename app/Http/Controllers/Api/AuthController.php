// app/Http/Controllers/Api/AuthController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->email,
            $request->password,
            $request->ip()
        );

        return response()->json([
            'token' => $result['token'],
            'user'  => [
                'user_id'   => $result['user']->user_id,
                'user_name' => $result['user']->user_name,
                'role'      => $result['user']->role,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user(), $request->ip());

        return response()->json(['message' => 'ログアウトしました。'], Response::HTTP_OK);
    }
}