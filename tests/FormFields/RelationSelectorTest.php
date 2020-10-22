<?php

namespace VoyagerRelationSelector\Tests\FormFields;

use VoyagerRelationSelector\Exceptions\RelationSelectorException;
use VoyagerRelationSelector\FormFields\RelationSelector;
use VoyagerRelationSelector\Tests\DatabaseTestCase;

class RelationSelectorTest extends DatabaseTestCase
{
    public function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }

    public function testExceptionRelation()
    {
        $class = new RelationSelector();

        $row = new \stdClass();
        $dataType = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('relation and model is not found');

        $class->createContent($row, $dataType, $dataTypeContent, $options);
    }

    public function testExceptionResourcesUrl()
    {
        $class = new RelationSelector();

        $row = new \stdClass();
        $dataType = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $options->relation = 'bar';

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('option resources_url is not found');

        $class->createContent($row, $dataType, $dataTypeContent, $options);
    }

//    public function testExceptionLevel()
//    {
//        $class = new RelationSelector();
//
//        $row = new \stdClass();
//        $dataType = new \stdClass();
//        $dataTypeContent = new \stdClass();
//        $options = collect();
//        $options->model = 'bar';
//        $options->resources_url = 'bar';
//
//        $this->expectException(RelationSelectorException::class);
//        $this->expectExceptionMessage('option level is not found');
//
//        $class->createContent($row, $dataType, $dataTypeContent, $options);
//    }
}
