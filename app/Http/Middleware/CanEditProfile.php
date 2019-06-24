<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CanEditProfile
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws HttpException
     */
    public function handle($request, Closure $next)
    {
        $user = $request->route('user');

        if (Auth::user()->isNot($user)) {
            //For better view format
            throw new HttpException(403,'You don\'t have permissions to edit this profile.');
        }

        return $next($request);
    }
}
