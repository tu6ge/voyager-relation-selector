<?php

use Illuminate\Database\Seeder;

class UnRegionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('regions')->whereRaw(1)->delete();
    }
}