<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('categories')->insert([
            [
                'title' => 'test category title 1',
                'description' => 'test description 1'
            ],
            [
                'title' => 'test category title 2',
                'description' => 'test description 2'
            ]
        ]);
    }
}
