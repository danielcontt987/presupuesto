<?php

namespace App\Http\Controllers;

use App\Microservices\Area as AreaMS;
use App\Models\Area;
use App\Models\AreaUser;
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

    public function consultAreadetails(Request $request){
        try{
            $area_id = $request->input('area_id');
            $area = Area::where('id', $area_id)->first();

            $area = DB::select("SELECT a.name,a.folio,COUNT(DISTINCT(au.user_id)) as users
                      FROM areas a 
                      LEFT JOIN area_users au on a.id=au.area_id
                      WHERE a.id='$area_id'
                      GROUP BY a.id
                      ORDER BY a.name 
                      LIMIT 1
                     ");    
            $users = DB::select("SELECT au.id as areauser_id, u.id as id, CONCAT(u.name, ' ', u.lastname) as name, u.img as img, au.isincharge as encargado
                        FROM areas a 
                        INNER JOIN area_users au ON a.id = au.area_id
                        INNER JOIN users u ON u.id = au.user_id
                        WHERE a.id = '$area_id' AND a.deleted_at IS NULL AND u.deleted_at IS NULL
                        GROUP BY u.id
                        ORDER BY u.name
                     ");          
            $permissions = DB::select("SELECT m.id as module_id,m.name,
                          IF((SELECT COUNT(*) FROM permissions where permissions.module_id=m.id and permissions.area_id='$area_id' and permissions.deleted_at is null) > 0,1,0) as granted
                      FROM modules m WHERE m.deleted_at is null
                      GROUP BY m.id
                      ORDER BY m.name 
                     ");
            foreach ($users as $key => $u) {
              $u->encargado = intval($u->encargado);
            }            
            foreach ($permissions as $key => $p) {
              $p->granted = intval($p->granted);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>"500",'data'=>$e->getMessage()]);
        }
        return response()->json(["status" => "200","area"=>$area[0],"users"=>$users,"permissions"=>$permissions, 'commission' => $commission]);
    } 
}
