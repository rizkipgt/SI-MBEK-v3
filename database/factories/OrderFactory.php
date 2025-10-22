<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Kambing;
use App\Models\Domba;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $category = $this->faker->randomElement(['kambing', 'domba']);
        $produkId = $category === 'kambing' ? Kambing::factory() : Domba::factory();

        return [
            'order_id' => 'ORD-' . $this->faker->unique()->randomNumber(6),
            'user_id' => User::factory(),
            'produk_id' => $produkId,
            'snap_token' => $this->faker->uuid,
            'gross_amount' => $this->faker->numberBetween(100000, 10000000),
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'qty' => 1,
            'status' => $this->faker->randomElement(['pending', 'settlement', 'cancel']),
            'payment_method' => $this->faker->randomElement(['midtrans', 'manual']),
            'bukti_transfer' => $this->faker->optional()->imageUrl(),
            'sender_name' => $this->faker->name,
            'bank_origin' => $this->faker->randomElement(['bca', 'bni', 'bri', 'mandiri']),
            'transfer_date' => $this->faker->date(),
            'admin_notes' => $this->faker->sentence,
        ];
    }
}