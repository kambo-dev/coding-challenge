<?php

namespace Database\Factories;

use App\Enums\RequestStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'initiator_id' => $this->faker->numberBetween(1, 50),
            'target_id' => $this->faker->numberBetween(51, 100),
            'status' => RequestStatuses::SENT
        ];
    }
}
