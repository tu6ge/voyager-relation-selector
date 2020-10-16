<?php 

use VoyagerRelationSelector\Models\Region;

Route::group(['as' => 'voyager-relation-selector.', 'prefix'=>'vrs'], function () {
    Route::get('region/{parent_id?}', function ($parent_id = 0) {
        return Region::where('parent_id', $parent_id)->get()->map(function ($res) {
            return [
                'value' => $res->id,
                'label' => $res->name,
                'leaf'  => $res->level >= 3,
            ];
        });
    })->where([
        'parent_id' => '[0-9]+',
    ]);

    Route::get('main.js', 'VoyagerRelationSelector\Http\Controllers\GenerateJsController@index');
});
