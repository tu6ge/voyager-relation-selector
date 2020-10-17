<?php

namespace VoyagerSelectRelation\Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use VoyagerRelationSelector\Tests\DatabaseTestCase;
use VoyagerRelationSelector\Traits\RelationModel;

class RelationModelTest extends DatabaseTestCase
{
    public function testGetParents()
    {
        DB::table('foo')->insert([
            'id'                => 34,
            'test_parent_id'    => 0,
        ]);

        $this->assertEquals([34], (new FooHasParent())->getParents(34));

        DB::table('foo')->insert([
            'id'                => 55,
            'test_parent_id'    => 34,
        ]);
        ()
        $this->assertEquals([34, 55], (new FooHasParent())->getParents(55));

        DB::table('foo')->insert([
            'id'                => 67,
            'test_parent_id'    => 55,
        ]);

        $this->assertEquals([34, 55, 67], (new FooHasParent())->getParents(67));
    }
}

class FooHasParent extends Model
{
    use RelationModel;

    protected $table = 'foo';

    protected $parentKey = 'test_parent_id';
}
