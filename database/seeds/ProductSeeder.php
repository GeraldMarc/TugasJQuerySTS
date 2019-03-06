<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 100; $i++){
            DB::table('products')->insert([
                'sku' => str_random(10),
                'name' => $faker->word,
                'description' => $faker->sentence,
                'unit_price' => rand()%100000+1,
                'product_category_id' => rand()%10+1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' =>  \Carbon\Carbon::now()
            ]);
        }
    }
}
