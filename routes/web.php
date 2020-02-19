<?php 

use VoyagerRelationSelector\Models\Region;

Route::group(['as' => 'voyager-relation-selector.','prefix'=>'vrs'], function(){
    Route::get('region/{parent_id?}', function($parent_id=0){
        return Region::where('parent_id', $parent_id)->get();
    })->where([
        'parent_id' => '[0-9]+'
    ]);

    Route::get('main.js', 'VoyagerRelationSelector\Http\Controllers\GenerateJsController@index');
});