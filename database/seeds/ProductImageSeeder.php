<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductImageSeeder extends Seeder
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
            for($j = 0; $j < 4; $j++){
                $isFirst = $j == 0 ? true : false;
                DB::table('product_images')->insert([
                    'product_image_url' => $faker->imageUrl,
                    'main_image' => $isFirst,
                    'product_id' => $i+1,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' =>  \Carbon\Carbon::now()
                ]);
            }
        }
    }
}
