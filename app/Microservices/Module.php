<?php

namespace App\Microservices;

use App\Models\Module as ModuleModel;

class Module extends Microservice
{
    public static function list()
    {
        return ModuleModel::get();
    }

    public static function store($name)
    {
        return ModuleModel::create([
            'name' => $name
        ]);
    }

    public static function update($request)
    {
        $module = ModuleModel::find($request->id);
        $module->name =  $request->name;
        $module->save();
        return $module;
    }
}
