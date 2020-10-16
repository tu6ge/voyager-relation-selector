<?php

namespace VoyagerRelationSelector\Traits;

trait RelationModel
{
    public function getParents($id)
    {
        if (!isset($this->parentKey)) {
            $this->parentKey = 'parent_id';
        }

        $info = $this->find($id);
        if ($info->{$this->parentKey} > 0) {
            return array_merge($this->getParents($info->{$this->parentKey}), [$id]);
        } else {
            return [$info->{$this->primaryKey}];
        }
    }
}
