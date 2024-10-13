<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districtId = DB::table('districts')->where('name', 'MBEYA MJINI')->first()->id;

        $wards = [
            'MBALIZI ROAD', 'MABATINI', 'FOREST', 'MAANGA', 'SINDE',
            'ISANGA', 'SISIMBA', 'ITIJI', 'MAENDELEO', 'MAJENGO',
            'GHANA', 'NONDE', 'ILEMI', 'RUANDA', 'IYELA',
            'NZOVWE', 'ITENDE', 'KALOBE', 'IYUNGA', 'IWAMBI',
            'ILOMBA',
            'MWAKIBETE',
            'TEMBELA',
            'MWANSANGA',
            'IGANZO',
            'UYOLE',
            'ISYESYE',
            'ITEZI',
            'MWANSENKWA',
            'ITAGANO',
            'NSOHO',
            'IZIWA',
            'NSALAGA',
            'IGAWILO',
            'IGANJO',
            'IDUDA',

        ];

        foreach ($wards as $ward) {
            DB::table('wards')->insert([
                'name' => $ward,
                'district_id' => $districtId
            ]);
        }
    }
}
