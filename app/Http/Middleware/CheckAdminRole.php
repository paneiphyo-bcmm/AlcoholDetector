// app/Http/Middleware/CheckAdminRole.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => '管理者権限が必要です。'], Response::HTTP_FORBIDDEN);
            }
            return redirect()->route('dashboard')->with('error', '管理者権限が必要です。');
        }

        return $next($request);
    }
}