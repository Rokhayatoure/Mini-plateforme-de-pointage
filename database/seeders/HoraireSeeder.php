<?php

namespace Database\Seeders;

use App\Models\Horaire;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HoraireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $horaires = [
            [
                'arriver' => true,
                'descente' => false,
                'date' => Carbon::now()->format('Y-m-d'),
                'heur' => Carbon::now()->format('H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
    }
}
