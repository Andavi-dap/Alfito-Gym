<?php

namespace Database\Factories;

use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipPlanFactory extends Factory
{
    protected $model = MembershipPlan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Plan',
            'duration_months' => 1,
            'price' => 100000,
            'is_active' => true,
        ];
    }
}
