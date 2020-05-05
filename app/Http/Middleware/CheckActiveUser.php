<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class CheckActiveUser
{
    /**
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (isset($user)) {
            if ($user->active !== "Y") {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ваша учетная запись деактивирована'
                ], 401);
            }
            return $next($request);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Зайдите под своей учетной записью'
        ], 401);
    }
}
