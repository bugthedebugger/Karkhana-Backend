<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        $authUser = Auth::user();
        $superAdmin = 'SuperAdmin';

        if($authUser) {
            $userRoles = $authUser->roles;
            foreach($userRoles as $role) {
                if ( $role->name == $superAdmin && $role->is_admin ) {
                    return $next($request);
                }
            } 
        } 
        return response('Unauthorized.', 401);
        
    }
}
