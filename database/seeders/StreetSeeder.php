<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StreetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'SABASABA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'KABISA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'KISOKI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'MWASYOGE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'SENJELE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'SABASABA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'KABISA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'KISOKI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MBALIZI ROAD', 'street' => 'MWASYOGE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'SENJELE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'MABATINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'MIANZINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'KAJIGILI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'KISUNGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MABATINI', 'street' => 'SIMIKE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'META'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'KADEGE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'MUUNGANO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'MAKANISANI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'BENKI KUU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'MAGHOROFANI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'FOREST', 'street' => 'FOREST MPYA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'MAANGA A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'MAANGA B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'MAENDELEO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'MAFIAT'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'NDONGOLE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'SINDE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAANGA', 'street' => 'MWAMFUPE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SINDE', 'street' => 'KAGWINA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SINDE', 'street' => 'ILOLO KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SINDE', 'street' => 'JANIBICHI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SINDE', 'street' => 'SINDE A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'ISANGA KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'ILOLO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'WIGAMBA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'MKUJU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'IGOMA ILOLO A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'IGOMA ILOLO B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISANGA', 'street' => 'MMITA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'UZUNGUNI A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'SOKO KUU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'UZUNGUNI B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'JAKARANDA B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'TANESCO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'SISIMBA', 'street' => 'JAKARANDA A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITIJI', 'street' => 'MWASANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITIJI', 'street' => 'MBWILE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITIJI', 'street' => 'ITIJI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITIJI', 'street' => 'MAKABURINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAENDELEO', 'street' => 'COMMUNITY CENTRE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAENDELEO', 'street' => 'KIWANJA NGOMA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAENDELEO', 'street' => 'SOKO MATOLA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAENDELEO', 'street' => 'KIWANJA MPAKA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAENDELEO', 'street' => 'KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAJENGO', 'street' => 'MAJENGO KASKAZINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MAJENGO', 'street' => 'MAJENGO KUSINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'GHANA', 'street' => 'MBATA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'GHANA', 'street' => 'GHANA MASHARIKI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'GHANA', 'street' => 'GHANA MAGHARIBI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NONDE', 'street' => 'MWALINGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NONDE', 'street' => 'MBWILE B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NONDE', 'street' => 'MBWILE A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NONDE', 'street' => 'NONDE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'MWAFUTE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'MASEWE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'MAPELELE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'MAANGA VETA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'ILINDI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILEMI', 'street' => 'ILEMI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'SOKO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'ILOLO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'MKOMBOZI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'KABWE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'MAKUNGURU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'SOWETO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'BENKI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'MWENGE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'WAKULIMA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'RUANDA', 'street' => 'MTONI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'ILEMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'ILEMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'PAMBOGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'MAPAMBANO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'BLOCK T'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'IYELA NAMBA 1'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'NYIBUKO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'IYELA NAMBA 2'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYELA', 'street' => 'AIRPORT'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NZOVWE', 'street' => 'NDANYELA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NZOVWE', 'street' => 'KILIMAHEWA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NZOVWE', 'street' => 'HALENGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NZOVWE', 'street' => 'NZOVWE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'ISONTA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'ITENDE KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'GOMBE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'INYALA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'LUSUNGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITENDE', 'street' => 'ITETE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'MAJENGO A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'MAJENGO MAPYA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'MAENDELEO A'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'MAENDELEO B'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'KALOBE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'KALOBE', 'street' => 'DDC'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYUNGA', 'street' => 'MAENDELEO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYUNGA', 'street' => 'INYALA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYUNGA', 'street' => 'SISINTILA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYUNGA', 'street' => 'IGALE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IYUNGA', 'street' => 'IKUTI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'UTULIVU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'LUMBILA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'ILEMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'IVWANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'KANDETE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'NDEJE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IWAMBI', 'street' => 'MAYOMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'KAGERA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'TONYA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'ITUHA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'HAYANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'SAE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'ILOMBA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ILOMBA', 'street' => 'IHANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'NG\'OSI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'NYIBUKO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'IVUMWE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'SHEWA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'VIWANDANI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'ITONGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWAKIBETE', 'street' => 'BOMBA MBILI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'TEMBELA', 'street' => 'RELI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'TEMBELA', 'street' => 'TEMBELA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSANGA', 'street' => 'NDUGUYA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSANGA', 'street' => 'ISOSO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANZO', 'street' => 'IGANZO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANZO', 'street' => 'NKUYU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANZO', 'street' => 'MWAMBENJA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANZO', 'street' => 'IGODIMA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'UYOLE', 'street' => 'HASANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'UYOLE', 'street' => 'IBARA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'UYOLE', 'street' => 'IWAMBALA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'UYOLE', 'street' => 'UTUKUYU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISYESYE', 'street' => 'MWANTENGULE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISYESYE', 'street' => 'VINGUNGUTI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ISYESYE', 'street' => 'RRM'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITEZI', 'street' => 'ITEZI MAGHARIBI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITEZI', 'street' => 'MWASOTE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITEZI', 'street' => 'GOMBE KASKAZINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITEZI', 'street' => 'GOMBE KUSINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSENKWA', 'street' => 'LUWALA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSENKWA', 'street' => 'MENGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSENKWA', 'street' => 'MWANZUMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'MWANSENKWA', 'street' => 'ILEMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITAGANO', 'street' => 'IPOMBO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'ITAGANO', 'street' => 'ITAGANO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSOHO', 'street' => 'NSOHO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSOHO', 'street' => 'KILABUNI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSOHO', 'street' => 'IDUNDA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSOHO', 'street' => 'MBEYA PEAK'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IZIWA', 'street' => 'ISUMBI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IZIWA', 'street' => 'ISENGO'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IZIWA', 'street' => 'IDUDA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IZIWA', 'street' => 'ILUNGU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IZIWA', 'street' => 'IMBEGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'NSALAGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'NTUNDU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'ITEZI MASHARIKI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'ITEZI MLIMANI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'MAJENGO MAPYA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'KIBONDE NYASI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'NSALAGA', 'street' => 'IGAMBA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGAWILO', 'street' => 'SOKONI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGAWILO', 'street' => 'CHEMCHEM'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGAWILO', 'street' => 'MWANYANJE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGAWILO', 'street' => 'MPONJA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'MTAKUJA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'ILOWE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'ISHINGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'MWANYANJE'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'IKHANGA'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IGANJO', 'street' => 'ITANJI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IDUDA', 'street' => 'KANDA YA CHINI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IDUDA', 'street' => 'KANDA YA KATI'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IDUDA', 'street' => 'KANDA YA JUU'],
            ['region' => 'MBEYA', 'district' => 'MBEYA MJINI', 'ward' => 'IDUDA', 'street' => 'MWAHALA']
        ];

        foreach ($data as $item) {
            $region = DB::table('regions')->where('name', $item['region'])->first();
            if (!$region) {
                echo "Error: Region '{$item['region']}' not found. Skipping street '{$item['street']}'\n";
                continue;
            }

            $regionId = $region->id;

            $district = DB::table('districts')->where('name', $item['district'])
                ->where('region_id', $regionId)
                ->first();
            if (!$district) {
                echo "Error: District '{$item['district']}' not found in region '{$item['region']}'. Skipping street '{$item['street']}'\n";
                continue;
            }

            $districtId = $district->id;

            $ward = DB::table('wards')->where('name', $item['ward'])
                ->where('district_id', $districtId)
                ->first();
            if (!$ward) {
                echo "Error: Ward '{$item['ward']}' not found in district '{$item['district']}'. Skipping street '{$item['street']}'\n";
                continue;
            }

            $wardId = $ward->id;

            DB::table('streets')->insert([
                'name' => $item['street'],
                'ward_id' => $wardId,
            ]);
        }
    }
}
