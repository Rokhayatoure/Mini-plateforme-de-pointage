<?php

namespace Database\Factories;

use App\Models\Horaire;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    public function definition(): array
    {
        $role = Role::inRandomOrder()->first();
        $horaire = Horaire::inRandomOrder()->first();

        return [
            'name' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'numero_telephone' => $this->faker->phoneNumber,
            'password' => bcrypt('password'), // default password for testing
        //   'horaire_id' => $horaire ? $horaire->id : Horaire::factory(),
            'role_id' => $role ? $role->id : Role::factory(),
        ];
    }
}
