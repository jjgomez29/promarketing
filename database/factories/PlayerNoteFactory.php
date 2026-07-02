<?php

namespace Database\Factories;

use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerNote>
 */
class PlayerNoteFactory extends Factory
{
    protected $model = PlayerNote::class;

    public function definition(): array
    {
        return [
            'player_id' => User::factory(),
            'author_id' => User::factory(),
            'content'   => $this->faker->paragraph(),
        ];
    }
}
