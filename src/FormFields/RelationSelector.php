<?php 

namespace VoyagerRelationSelector\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Toolkit;

class RelationSelector extends AbstractHandler
{
    protected $name = 'Relation Selector';
    protected $codename = 'relation-selector';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        //dd($row,$options, $dataTypeContent);
        $value = [];
        if($dataTypeContent->exists){
            $value[$row->field] = $dataTypeContent->{$row->field};
            foreach($options->relation as $key=>$val){
                $value[] = $dataTypeContent->{$val};
            }
        }

        Toolkit::append_js(sprintf('vrs/main.js?id=%s&value=%s', $row->id, implode(',',$value)));

        return view('voyager_relation_selector::formfields.relation_selector', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}