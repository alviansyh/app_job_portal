<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('areas')->insert([
            0 => array ('id' => 1,'area_name' => 'Aceh','country_id' => 1),
            1 => array ('id' => 2,'area_name' => 'Bali','country_id' => 1),
            2 => array ('id' => 3,'area_name' => 'Banten','country_id' => 1),
            3 => array ('id' => 4,'area_name' => 'Bengkulu','country_id' => 1),
            4 => array ('id' => 5,'area_name' => 'Yogyakarta','country_id' => 1),
            5 => array ('id' => 6,'area_name' => 'DKI Jakarta','country_id' => 1),
            6 => array ('id' => 7,'area_name' => 'Gorontalo','country_id' => 1),
            7 => array ('id' => 8,'area_name' => 'Jambi','country_id' => 1),
            8 => array ('id' => 9,'area_name' => 'Jawa Barat','country_id' => 1),
            9 => array ('id' => 10,'area_name' => 'Jawa Tengah','country_id' => 1),
            10 => array ('id' => 11,'area_name' => 'Jawa Timur','country_id' => 1),
            11 => array ('id' => 12,'area_name' => 'Kalimantan Barat','country_id' => 1),
            12 => array ('id' => 13,'area_name' => 'Kalimantan Selatan','country_id' => 1),
            13 => array ('id' => 14,'area_name' => 'Kalimantan Tengah','country_id' => 1),
            14 => array ('id' => 15,'area_name' => 'Kalimantan Timur','country_id' => 1),
            15 => array ('id' => 16,'area_name' => 'Kalimantan Utara','country_id' => 1),
            16 => array ('id' => 17,'area_name' => 'Kepulauan Bangka Belitung','country_id' => 1),
            17 => array ('id' => 18,'area_name' => 'Kepulauan Riau','country_id' => 1),
            18 => array ('id' => 19,'area_name' => 'Lampung','country_id' => 1),
            19 => array ('id' => 20,'area_name' => 'Maluku','country_id' => 1),
            20 => array ('id' => 21,'area_name' => 'Maluku Utara','country_id' => 1),
            21 => array ('id' => 22,'area_name' => 'Nusa Tenggara Barat','country_id' => 1),
            22 => array ('id' => 23,'area_name' => 'Nusa Tenggara Timur','country_id' => 1),
            23 => array ('id' => 24,'area_name' => 'Papua','country_id' => 1),
            24 => array ('id' => 25,'area_name' => 'Papua Barat','country_id' => 1),
            25 => array ('id' => 26,'area_name' => 'Riau','country_id' => 1),
            26 => array ('id' => 27,'area_name' => 'Sulawesi Barat','country_id' => 1),
            27 => array ('id' => 28,'area_name' => 'Sulawesi Selatan','country_id' => 1),
            28 => array ('id' => 29,'area_name' => 'Sulawesi Tengah','country_id' => 1),
            29 => array ('id' => 30,'area_name' => 'Sulawesi Tenggara','country_id' => 1),
            30 => array ('id' => 31,'area_name' => 'Sulawesi Utara','country_id' => 1),
            31 => array ('id' => 32,'area_name' => 'Sumatera Barat','country_id' => 1),
            32 => array ('id' => 33,'area_name' => 'Sumatera Selatan','country_id' => 1),
            33 => array ('id' => 34,'area_name' => 'Sumatera Utara','country_id' => 1),
        ]);
    }
}
