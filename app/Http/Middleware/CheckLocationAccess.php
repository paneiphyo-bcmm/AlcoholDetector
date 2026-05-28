// app/Http/Middleware/CheckLocationAccess.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLocationAccess
{
    // FR-004: 拠点管理権限による閲覧制御
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => '認証が必要です。'], Response::HTTP_UNAUTHORIZED);
        }

        // 管理者はすべての拠点にアクセス可能
        if ($user->isAdmin()) {
            return $next($request);
        }

        $locationId = $request->route('location_id') ?? $request->input('location_id');

        if ($locationId && $user->location_id !== $locationId) {
            return response()->json(['message' => 'この拠点へのアクセス権限がありません。'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}