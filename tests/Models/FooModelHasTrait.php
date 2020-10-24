<?php

namespace VoyagerRelationSelector\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use VoyagerRelationSelector\Traits\RelationModel;

class FooModelHasTrait extends Model
{
    use RelationModel;
}
