<?php

namespace App\Http\Middleware;

use Closure;

class ResponseFormatter
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $json = json_decode($response->getContent(), true);
        $statusCode = $response->getStatusCode();
        $headers = $response->headers->all();

        $result = [
            'data' => $json,
            'error' => null,
            'success' => true,
            'status_code' => $statusCode,
        ];

        if ($statusCode >= 400 && $statusCode <= 599) {
            // Dingo API catches all exceptions and formats the errors for us.
            // We just need to return it.
            $result = array_merge($result, $json, [
                'data' => null,
                'success' => false,
            ]);
        }

        return response()->json($result, $statusCode, $headers);
    }
}
