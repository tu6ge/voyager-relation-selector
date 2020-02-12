<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    public function run()
    {
        $exist = DB::table('regions')->count();
        if($exist>0){
            return false;
        }
        $data = file_get_contents('./region.json');
        $data = json_decode($data, true);
        DB::table('regions')->insert($data);
    }
}