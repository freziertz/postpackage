<?php

namespace Freziertz\PostPackage\Http\Middleware;

use Closure;

class InjectHelloWorld
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Perform action

        return $response;
    }
}
