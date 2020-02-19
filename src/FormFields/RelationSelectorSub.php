<?php 

namespace VoyagerRelationSelector\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Toolkit;

class RelationSelectorSub extends AbstractHandler
{
    protected $name = 'Relation Selector Sub';
    protected $codename = 'relation-selector-sub';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return '';
    }
}