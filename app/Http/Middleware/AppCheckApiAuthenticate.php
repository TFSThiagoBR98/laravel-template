<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Throwable;

class AppCheckApiAuthenticate
{
    /**
     * Handle the incoming requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if ($request->getContentTypeFormat() === 'application/json') {
            if ($request->header('X-Firebase-AppCheck') !== null) {
                try {
                    Firebase::project('app')->appCheck()->verifyToken($request->header('X-Firebase-AppCheck'));
                    return $next($request);
                } catch (Throwable $e) {
                    throw new AuthorizationException();
                }
            } else {
                throw new AuthorizationException();
            }
        } else {
            return $next($request);
        }
    }
}
