<?php

namespace VoyagerRelationSelector\Traits;

use VoyagerRelationSelector\Exceptions\RelationSelectorException;

trait RelationModel
{
    public function getParents($id)
    {
        if (!isset($this->parentKey)) {
            throw new RelationSelectorException(sprintf('model [%s] is must set parentKey protected', __CLASS__));
        }

        $info = $this->find($id);
        if ($info->{$this->parentKey} > 0) {
            return array_merge($this->getParents($info->{$this->parentKey}), [$id]);
        } else {
            return [$info->{$this->primaryKey}];
        }
    }
}
