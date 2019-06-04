<?php

/**
 * Middleware yang digunakan untuk verifikasi AUTH pada mobile.
 *
 * @author     Odenktools
 * @license    MIT
 * @package    App\Http\Middleware
 * @copyright  (c) 2019, PerluApps Technology
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $errors = array();
        $errors['meta']['code'] = 401;
        $errors['meta']['message'] = trans('message.api.error.global');
        $errors['meta']['api_version'] = '1.0';
        $errors['meta']['method'] = $request->server('REQUEST_METHOD');
        $errors['errors'] = array();
        $errors['pageinfo'] = (object)[];
        $errors['data']['message'] = trans('message.api.error.global');
        $errors['data']['items'] = array();
        if (Auth::guard($guard)->user()) {
            return $next($request);
        } else {
            if ($request->ajax() || $request->wantsJson()) {
                $errors['errors'] = array('Unauthorized');
                return new JsonResponse($errors, 401);
            } else {
                $errors['errors'] = array('Unauthorized');
                //return redirect('/home');
                return new JsonResponse($errors, 401);
            }
        }
    }
}