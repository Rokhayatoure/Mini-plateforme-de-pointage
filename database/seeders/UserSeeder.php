<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('nomRole', 'admin')->first();

        if ($adminRole) {
            User::factory()->create([
                'name' => 'Dia',
                'prenom' => 'admin',
                'email' => 'admin@gmail.com',
                'numeroTelephone' => '+221774003030',
                'password' => bcrypt('admin@123'),
                'roleId' => $adminRole->id,
            ]);
        } else {
            $this->command->info('Le rôle "admin" n\'a pas été trouvé. Assurez-vous qu\'il existe dans la table des rôles.');
        }
    }
}
