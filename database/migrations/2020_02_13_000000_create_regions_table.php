<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegionsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('short_name')->comment('行政区划名词，比如山东');
            $table->string('name')->comment('行政区划名词，比如山东省');
            $table->tinyInteger('level')->comment('行政级别，省市区分别是1，2，3');
            $table->string('pinyin', 100)->comment('拼音');
            $table->string('code', 5)->nullable()->comment('长途区号');
            $table->char('zip_code', 6)->nullable()->comment('邮政编码');
            $table->char('first', 1)->nullable()->comment('首字母');
            $table->decimal('lng', 10, 6)->nullable()->comment('所在经度');
            $table->decimal('lat', 10, 6)->nullable()->comment('所在纬度');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regions');
    }
}
