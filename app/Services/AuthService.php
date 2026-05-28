// app/Services/AuthService.php
<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\OperationLogRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private readonly OperationLogRepository $operationLogRepository
    ) {}

    public function login(string $email, string $password, string $ipAddress): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['認証情報が正しくありません。'],
            ]);
        }

        $token = $user->createToken('auth_token')->accessToken;

        $this->operationLogRepository->create(
            $user->user_id,
            'ログイン',
            $ipAddress
        );

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }

    public function logout(User $user, string $ipAddress): void
    {
        $user->tokens()->delete();

        $this->operationLogRepository->create(
            $user->user_id,
            'ログアウト',
            $ipAddress
        );
    }
}