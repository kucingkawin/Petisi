<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();
        $role = strtolower($role);

        if($role == "user")
        {
            if($user->role_id != 1)
                return redirect(route('admin.index'));
        }
        else if($role == "admin")
        {
            if($user->role_id != 2)
                return redirect(route('user.index'));
        }

        return $next($request);
    }
}
