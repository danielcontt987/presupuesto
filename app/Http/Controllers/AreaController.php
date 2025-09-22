<?php

namespace App\Http\Controllers;

use App\Microservices\Area as AreaMS;
use App\Models\Area;
use App\Models\AreaUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function get()
    {
        return response()->json([
            'area' => AreaMS::get(Auth::user()->getBusiness()),
            'users' => AreaMS::getUser(Auth::user()->getBusiness()),
        ], 200);
    }

    public function consultAreadetails(Request $request)
    {
        try {
            $area_id = $request->input('area_id');

            // Consultar el área
            $area = DB::table('areas')
                ->select('name', 'folio', DB::raw('COUNT(DISTINCT(au.user_id)) as users'))
                ->leftJoin('area_users as au', 'areas.id', '=', 'au.area_id')
                ->where('areas.id', $area_id)
                ->groupBy('areas.id', 'name', 'folio')
                ->orderBy('areas.name')
                ->first();

            // Consultar los usuarios
            $users = DB::table('areas')
                ->select('au.id as areauser_id', 'u.id', DB::raw("CONCAT(u.name, ' ', u.lastname) as name"), 'u.img', DB::raw('MAX(au.isincharge) as encargado'))
                ->join('area_users as au', 'areas.id', '=', 'au.area_id')
                ->join('users as u', 'u.id', '=', 'au.user_id')
                ->where('areas.id', $area_id)
                ->whereNull('areas.deleted_at')
                ->whereNull('u.deleted_at')
                ->groupBy('au.id', 'u.id', 'u.name', 'u.lastname', 'u.img')
                ->orderBy('u.name')
                ->get();

            // Consultar permisos
            $permissions = DB::table('modules as m')
                ->select('m.id as module_id', 'm.name', DB::raw('IF((SELECT COUNT(*) FROM permissions WHERE permissions.module_id = m.id AND permissions.area_id = ' . $area_id . ' AND permissions.deleted_at IS NULL) > 0, 1, 0) as granted'))
                ->whereNull('m.deleted_at')
                ->groupBy('m.id', 'm.name')
                ->orderBy('m.name')
                ->get();

            // Convertir campos a enteros
            foreach ($users as $user) {
                $user->encargado = intval($user->encargado);
            }
            foreach ($permissions as $permission) {
                $permission->granted = intval($permission->granted);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => "500", 'data' => $e->getMessage()]);
        }

        return response()->json(["status" => "200", "area" => $area, "users" => $users, "permissions" => $permissions]);
    }
    public function storePermission(Request $request)
    {
        try {
            $ids = $request->ids;
            $area_id = $request->area_id;
            foreach ($ids as $value) {
                $permission = Permission::where('module_id', $value)->first();
                if ($permission == null) {
                    Permission::create([
                        'module_id' => $value,
                        'area_id' => $area_id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(["status" => "500", "error" => $e->getMessage()]);
        }
        return response()->json(["status" => "200"]);
    }
    public function listPermission(Request $request)
    {
        try {
            $list = Permission::get();
        } catch (\Exception $e) {
            return response()->json(["status" => "500", "error" => $e->getMessage()]);
        }
        return response()->json(["status" => "200", "permission" => $list]);
    }
}
