<?php

namespace App\Http\Middleware;

use App\Models\AreaUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if (Auth::check() || $permission === "public") {
            if ($permission === "public") {
                return $next($request);
            } else {
                $user_id = Auth::user()->id;
                $areauser = AreaUser::where('user_id', $user_id)->first();
                $tiene_permisos = 0;
                if (!!$areauser && $areauser->area) {
                    $tiene_permisos = $areauser->area->permissions()->whereHas('module', function ($q) use ($permission) {
                        $q->whereIn('name', explode(',', $permission));
                    })->count();
                } else {
                    return redirect('/inicio');
                }

                if ($tiene_permisos === 0)
                    return redirect('/inicio');
                return $next($request);
            }
        } else {
            return redirect('/inicio');
        }
    }
}
