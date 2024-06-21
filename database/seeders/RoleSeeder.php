<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ["name" => "peserta_magang"],
            ["name" => "pembimbing"],
            ["name" => "admin"],
        ];

        foreach($role as $data){
            Role::create($data);
        }
    }
}
