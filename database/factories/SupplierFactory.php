<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->companyPrefix. '.' .$this->faker->lastName,
            'telp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'rekening' => mt_rand(10000000000000,99999999999999),
            'alamat' => $this->faker->streetAddress. '-' .$this->faker->city. '-' .$this->faker->postcode.'-' .$this->faker->stateAbbr,

        ];
    }
}
