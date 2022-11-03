<?php

namespace App\Http\Middleware;

use App\Models\SuspendUser;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Support\Facades\Cache;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $token = $request->header('Authorization', '');
            if (str_starts_with($token, 'Bearer ')) {
                $token = substr($token, 7);
            }
            if (is_null($request->user())) {
                return response()->json(['success' => false, 'message' => 'You`re can`t use this route.'], 403);
            }
            if (!$request->user()->checkingToken($token)) {
                return response()->json(['success' => false, 'message' => 'You`re can`t use this route.'], 403);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Authorization not found.'], 403);
        }
        return $next($request);
    }
}
