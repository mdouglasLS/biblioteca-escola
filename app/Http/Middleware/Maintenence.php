<?php

namespace App\Http\Middleware;

class Maintenence
{

    public function handle($request,$next)
    {
        if(getenv('MAINTENENCE') == 'true') {
            throw new \Exception("Página em manutenção.",200);
        }

        return $next($request);

    }

}