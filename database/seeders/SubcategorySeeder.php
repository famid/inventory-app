<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('subcategories')->insert([
            [
                'title' => 'test subcategory title 1',
                'description' => 'test description 1',
                'category_id' => 2
            ],
            [
                'title' => 'test subcategory title 2',
                'description' => 'test description 2',
                'category_id' => 2
            ],
            [
                'title' => 'test subcategory title 3',
                'description' => 'test description 3',
                'category_id' => 3
            ],
            [
                'title' => 'test subcategory title 4',
                'description' => 'test description 4',
                'category_id' => 3
            ],

        ]);
    }
}
