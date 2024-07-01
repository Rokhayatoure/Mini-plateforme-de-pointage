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
        Role::create(['nomRole' => 'admin']);
        Role::create(['nomRole' => 'developeur']);
        Role::create(['nomRole' => 'commercial']);
        Role::create(['nomRole' => 'RH']);
        Role::create(['nomRole' => 'telecom']);
        Role::create(['nomRole' => 'reseau']);
        
    }
}
