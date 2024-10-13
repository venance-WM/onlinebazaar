<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Grocery and Beverages',
                'description' => 'Food items, drinks, and other grocery products.'
            ],
            [
                'name' => 'Fashion and Apparel',
                'description' => 'Clothing, shoes, and fashion accessories.'
            ],
            [
                'name' => 'Health and Beauty',
                'description' => 'Health products, skincare, cosmetics, and beauty supplies.'
            ],
            [
                'name' => 'Home and Kitchen Appliances',
                'description' => 'Furniture, home decor, gardening tools, and supplies.'
            ],
            [
                'name' => 'Electronics and Gadgets',
                'description' => 'Electronic gadgets, home appliances, and tech accessories.'
            ],
            [
                'name' => 'Art, Crafts, and Hobbies',
                'description' => 'Art supplies, craft materials, and hobby-related products.'
            ],
            [
                'name' => 'Agriculture and Fresh Products',
                'description' => 'Food, grains and mbogamboga.'
            ],
            [
                'name' => 'Automotives and Spare Parts',
                'description' => 'Equipment and apparel for sports and outdoor activities.'
            ],
            [
                'name' => 'Books and Media',
                'description' => 'Books, magazines, music, and other media.'
            ],
            [
                'name' => 'Home Utilities',
                'description' => 'Bed, Sofa, Cooking Utensils'
            ],
            [
                'name' => 'Books and Stationery',
                'description' => 'For Schools and Offices'
            ],
            [
                'name' => 'Suppliers',
                'description' => 'Gas Suppliers'
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}