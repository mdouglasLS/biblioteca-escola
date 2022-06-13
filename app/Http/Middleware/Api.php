<?php

namespace App\Http\Middleware;

class Api
{

    public function handle(object $request, $next)
    {
        $request->getRouter()->setContentType('application/json');

        return $next($request);
    }

}