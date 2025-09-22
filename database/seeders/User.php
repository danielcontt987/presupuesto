<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\AreaUser;
use App\Models\Business;
use App\Models\Colony;
use App\Models\Module;
use App\Models\Permission;
use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colony = Colony::create([
            'zipcode' => 63175,
            'settlement' => "Pera",
            'settlement_type' => "Colonia",
            'municipality' => "Tepic",
            'state' => "Nayarit",
            'zone' => "Urbana",
        ]);

        $colonyId = $colony->id; // Get the ID as a scalar value

        $busines = Business::create([
            'img' => "NA",
            'name' => "NA",
            'pin' => "NA",
            'services' => "NA",
            'street' => "NA",
            'ext' => "NA",
            'int' => "NA",
            'colony_id' => $colonyId,
            'telephone1' => "NA",
            'telephone2' => "NA",
            'whatsapp' => "NA",
            'website' => "NA",
            'facebook' => "NA",
            'lat' => "NA",
            'log' => "NA",
            'fiscal_rfc' => "NA",
            'fiscal_corporative_name' => "NA",
            'fiscal_street' => "NA",
            'fiscal_ext' => "NA",
            'fiscal_int' => "NA",
            'fiscal_colony_id' => $colonyId,
            'timezone' => "NA",
        ]);

        $businesId = $busines->id;

        $area = Area::create([
            'name' => "General",
            'business_id' => $businesId,
            'folio' => "0001",
        ]);

        $areaId = $area->id;

        $user = ModelsUser::create([
            'work_number' => '25555425',
            'name' => "José Daniel",
            'lastname' => "Contreras Pérez",
            'phone' => 311256252,
            'img' => "NA",
            'email' => "jose_daniel16051999@outlook.com",
            'password' => Hash::make('12345678'),
            'street' => "Pera",
            'ext' => "48",
            'colony_id' => $colonyId,
            'curp' => "COPD990516HNTNRN03",
            'birthdate' => "1999/05/16",
            'birth_place' => "Tepic",
            'gender' => "H",
            'rfc' => "COPD990516I49",
            'nss' => "667878797979",
            'can_edit' => 1,
        ]);

        $userId = $user->id;

        AreaUser::create([
            'user_id' => $userId,
            'area_id' => $areaId,
        ]);

        $module = Module::create([
            'name' => 'Registrar modulos',
        ]);

        $moduleArea = Module::create([
            'name' => 'Áreas',
        ]);

        Permission::create([
            'area_id' => $areaId,
            'module_id' => $moduleArea->id,
        ]);

        Permission::create([
            'area_id' => $areaId,
            'module_id' => $module->id,
        ]);
    }
}
