<?php

namespace VoyagerRelationSelector\Tests\FormFields;

use VoyagerRelationSelector\FormFields\RelationSelectorParent;
use VoyagerRelationSelector\Tests\DatabaseTestCase;

class RelationSelectorParentTest extends DatabaseTestCase
{
    public function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }

    public function testExceptionRelation()
    {
        $class = new RelationSelectorParent();

        $row = new \stdClass();
        $dataType = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $res = $class->createContent($row, $dataType, $dataTypeContent, $options);
        $this->assertEquals($res, '');
    }
}
