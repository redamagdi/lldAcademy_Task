<?php

namespace Database\Factories;

use App\Models\Previliges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Previlige extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Previliges::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job'   => '1',
            'page'  => 'previliges',
            'v'  => 1,
            'e'  => 1,
            'a'  => 1,
            'd'  => 1,
        ];
    }
}
