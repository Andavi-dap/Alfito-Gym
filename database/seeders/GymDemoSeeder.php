<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\MembershipPlan;
use App\Models\Program;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GymDemoSeeder extends Seeder
{
    public function run(): void
    {
        $cities = ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Utara', 'Bandung', 'Surabaya', 'Semarang', 'Medan', 'Bali', 'Yogyakarta'];
        $streets = ['Jl. Jend. Sudirman', 'Jl. Gatot Subroto', 'Jl. HR Rasuna Said', 'Jl. MH Thamrin', 'Jl. Asia Afrika', 'Jl. Diponegoro', 'Jl. Malioboro', 'Jl. Sunset Road'];

        $locations = [];
        for ($i = 1; $i <= 10; $i++) {
            $locations[] = Location::firstOrCreate([
                'name' => "Alfito Fitness Center - Cabang {$i}"
            ], [
                'address' => $streets[array_rand($streets)] . " No. " . rand(1, 150),
                'city' => $cities[array_rand($cities)],
            ]);
        }

        $plansData = [
            ['name' => 'Silver Monthly Pass', 'price' => 300000, 'duration_months' => 1],
            ['name' => 'Gold Quarterly Pass', 'price' => 850000, 'duration_months' => 3],
            ['name' => 'Platinum Semi-Annual Pass', 'price' => 1600000, 'duration_months' => 6],
            ['name' => 'Diamond Annual Pass', 'price' => 3000000, 'duration_months' => 12],
            ['name' => 'VIP Unlimited Pass', 'price' => 5000000, 'duration_months' => 12],
        ];
        foreach ($plansData as $pd) {
            MembershipPlan::firstOrCreate(['name' => $pd['name']], [
                'price' => $pd['price'],
                'duration_months' => $pd['duration_months'],
                'is_active' => true,
            ]);
        }

        $specs = ['Bodybuilding & Hypertrophy', 'Yoga & Mobility', 'CrossFit & Functional', 'Weight Loss & Cardio', 'Powerlifting', 'Pilates & Core', 'Boxing & Conditioning'];
        $firstNames = ['Agus', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indah', 'Joko', 'Kartika', 'Lestari', 'Mahendra', 'Nina', 'Oki'];
        $lastNames = ['Santoso', 'Pratama', 'Wijaya', 'Kusuma', 'Saputra', 'Sari', 'Hidayat', 'Gunawan', 'Utami', 'Rahmawati'];

        $trainers = [];
        for ($i = 1; $i <= 25; $i++) {
            $trainers[] = Trainer::firstOrCreate([
                'name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)] . ' ' . $i
            ], [
                'specialization' => $specs[array_rand($specs)],
                'location_id' => $locations[array_rand($locations)]->id,
            ]);
        }

        $progNames = ['Powerlifting Master', 'Vinyasa Flow', 'HIIT Shred', 'CrossFit Arena', 'Extreme Weight Loss', 'Core & Abs Sculpt', 'Advanced Boxing', 'Functional Mobility', 'Senior Fitness', 'Marathon Endurance'];
        $categories = ['Strength', 'Flexibility', 'Cardio', 'CrossFit', 'Weight Loss', 'Core', 'Combat'];

        $programs = [];
        for ($i = 0; $i < count($progNames); $i++) {
            $prog = Program::firstOrCreate(['name' => $progNames[$i]], [
                'category' => $categories[array_rand($categories)],
                'is_active' => true,
            ]);
            $assignedTrainers = collect($trainers)->random(rand(2, 5))->pluck('id')->toArray();
            $prog->trainers()->sync($assignedTrainers);
            $programs[] = $prog;
        }

        for ($i = 1; $i <= 30; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            User::firstOrCreate([
                'email' => strtolower($firstName . '.' . $lastName . $i . '@alfitofitness.com')
            ], [
                'name' => "$firstName $lastName",
                'password' => Hash::make('Password123!'),
                'role' => 'member',
            ]);
        }
    }
}


