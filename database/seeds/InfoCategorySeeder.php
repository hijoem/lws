<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InfoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('info_categories')->insert([
            'id' => '1',
            'name' => 'Promo',
        ]);
        DB::table('info_categories')->insert([
            'id' => '2',
            'name' => 'Kebijakan Pemerintah',
        ]);
    }
}
