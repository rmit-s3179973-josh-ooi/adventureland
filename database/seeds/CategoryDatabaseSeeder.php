<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name'=>'Hiking']);
        Category::create(['name'=>'Road Trip']);
        Category::create(['name'=>'Cycling']);
        Category::create(['name'=>'Camping']);
        Category::create(['name'=>'Kayaking']);
        Category::create(['name'=>'Mountain Biking']);
    }
}
