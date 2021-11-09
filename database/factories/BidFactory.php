<?php

namespace Database\Factories;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bid::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => 8,  // Change the product id
            'user_id' => 1,
            'bid_amount' => $this->faker->numberBetween(101,50000),
            'win_status' => false
        ];
    }
}
