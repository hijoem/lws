<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->insert([
            'id' => '1',
            'name' => 'Makanan',
        ]);
        DB::table('product_category')->insert([
            'id' => '2',
            'name' => 'Minuman',
        ]);
    }
}
