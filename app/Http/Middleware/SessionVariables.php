<?php

namespace App\Http\Middleware;

use Closure;

class SessionVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($id = auth()->id() && ! $response->isServerError()) {
            $data = (array)json_decode($response->getContent(), true) + ['session' => \App\User::find($id)->toArray()];

            $status = $response->isEmpty() ? 200 : $response->status();

            $headers = $response->headers->allPreserveCase();

            return response()->json($data, $status, $headers);
        }

        return $response;
    }
}
