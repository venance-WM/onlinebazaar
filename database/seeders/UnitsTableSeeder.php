<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $units = [
            ['name' => 'items'],
            ['name' => 'pieces'],
             ['name' => 'kg'],
             ['name' => 'litres'],
             ['name' => 'boxes'],
             ['name' => 'grams'],
             ['name' => 'millilitres'],
             ['name' => 'dozens'],
             ['name' => 'packs'],
             ['name' => 'meters'],
             ['name' => 'pairs'],
             ['name' => 'feet'],
             ['name' => 'plates'],
         ];
 
         DB::table('units')->insert($units);
     }
}
