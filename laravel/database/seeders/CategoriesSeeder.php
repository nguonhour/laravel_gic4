<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed categories of products
        DB::table('categories')->insert([
            ['name' => 'Electronics'],
            ['name' => 'Books'],
            ['name' => 'Clothing'],
            ['name' => 'Home & Kitchen'],
            ['name' => 'Sports & Outdoors'],
        ]);
    }
}
