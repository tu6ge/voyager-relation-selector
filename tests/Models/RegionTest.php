<?php

namespace VoyagerRelationSelector\Tests\Models;

use ReflectionClass;
use ReflectionProperty;
use VoyagerRelationSelector\Models\Region;
use VoyagerRelationSelector\Tests\TestCase;

class RegionTest extends TestCase
{
    public function testTrait()
    {
        $reflect = new ReflectionClass(Region::class);

        $traits = $reflect->getTraits();

        $this->assertArrayHasKey('VoyagerRelationSelector\Traits\RelationModel', $traits);
    }

    public function testTable()
    {
        $model = new Region();

        $this->assertEquals('regions', $model->getTable());
    }

    public function testParentKey()
    {
        $reflect = new ReflectionClass(Region::class);

        $protected = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);

        $collect = collect($protected)->filter(function ($item) {
            return $item->name == 'parentKey';
        });

        $this->assertEquals(1, $collect->count());

        $region = new Region();

        $bar = function () {
            return $this->parentKey;
        };

        $baz = $bar->bindTo($region, $region);

        $this->assertEquals($baz(), 'parent_id');
    }
}
