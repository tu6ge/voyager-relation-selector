<?php

namespace VoyagerRelationSelector\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Models\DataRow;

class GenerateJsController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->get('id', 0);
        $value = $request->get('value', '[]');
        
        if(!empty($value)){
            $value = explode(',', $value);
            $value = collect($value)->map(function($res){
                return intval($res);
            });
            $value = $value->toJson();
        }else{
            $value = '[]';
        }
        
        return response()->view('vrs::generate-js.index', [
            'id'                        => $id,
            'value'                 => $value,
        ], 200, [
            'Content-Type' => 'text/javascript',
        ]);
    }
}