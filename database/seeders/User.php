<?php

namespace Database\Seeders;

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
        ModelsUser::create([
            'name' => 'Daniel',
            'lastname' => 'Contreras',
            'phone' => '3112312312',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
