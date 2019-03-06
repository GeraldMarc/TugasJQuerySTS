<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5',
                        'Category 6', 'Category 7', 'Category 8', 'Category 9', 'Category 10'];

        for($i = 0; $i < 10; $i++){
            DB::table('product_categories')->insert([
                'category_name' => $categories[$i],
                'visible' => rand()%2,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' =>  \Carbon\Carbon::now()
            ]);
        }
    }
}
