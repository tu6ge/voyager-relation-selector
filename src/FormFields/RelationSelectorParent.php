<?php

namespace VoyagerRelationSelector\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Toolkit;

class RelationSelectorParent extends AbstractHandler
{
    protected $name = 'Relation Selector Parent';
    protected $codename = 'relation-selector-parent';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return '';
    }
}
