<?php

use App\Customer;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Customer::truncate();

        foreach (range(10, 50) as $i) {
            Customer::create([
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => $faker->safeEmail,
                'address' => $faker->address
            ]);
        }
    }
}
