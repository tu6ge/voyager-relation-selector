<?php

namespace VoyagerRelationSelector\Models;

use Illuminate\Database\Eloquent\Model;
use VoyagerRelationSelector\Traits\RelationModel;

class Region extends Model
{
    use RelationModel;

    protected $table = 'regions';

    protected $parentKey = 'parent_id';
}
