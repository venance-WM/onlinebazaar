<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regionId = DB::table('regions')->where('name', 'MBEYA')->first()->id;

        DB::table('districts')->insert([
            ['name' => 'MBEYA MJINI', 'region_id' => $regionId],
        ]);
    }
}
