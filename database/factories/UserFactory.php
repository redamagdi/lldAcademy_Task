<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'   => 'Super Admin',
            'email'  => 'superAdmin@gmail.com',
            'phone'  => '00201063979463',
            'job'    => '1',
            'status' => '1',
            'password' => md5('123456'), // password
        ];
    }
}
