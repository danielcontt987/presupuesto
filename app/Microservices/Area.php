<?php

namespace App\Microservices;

use App\Models\Area as AreaModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Area extends Microservice
{
    public static function get($id)
    {
        $areas = AreaModel::withCount(['areaUsers as users_count' => function($query) {
            $query->whereNull('deleted_at')->distinct('user_id');
        }])
        ->where('business_id', $id)
        ->whereNull('deleted_at')
        ->where('name', '<>', 'Sin asignar')
        ->orderBy('name')
        ->get()
        
        ->map(function($area) {
            $userCount = $area->users_count;
            $area->users = $userCount == 1 ? '1 usuario' : "{$userCount} usuarios";
            return $area;
        });
        return $areas;           
    }

    public static function getUser($id) 
    {
        $users = User::select('users.id', DB::raw("CONCAT(users.name, ' ', users.lastname) as name"), 'users.email', 'areas.name as area', 'area_users.isincharge as encargado')
        ->leftJoin('area_users', 'users.id', '=', 'area_users.user_id')
        ->leftJoin('areas', 'areas.id', '=', 'area_users.area_id')
        ->where('areas.business_id', $id)
        ->whereNull('users.deleted_at')
        ->whereNull('area_users.deleted_at')
        ->orderBy('users.name')
        ->get();  
        
        return $users;
    }
}
