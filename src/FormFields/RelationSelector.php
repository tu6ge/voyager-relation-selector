<?php 

namespace VoyagerRelationSelector\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class RelationSelector extends AbstractHandler
{
    protected $codename = 'relation-selector';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager_relation_selector::formfields.relation_selector', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}