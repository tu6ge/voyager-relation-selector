<?php

namespace VoyagerRelationSelector\Tests\FormFields;

use Illuminate\Testing\TestResponse;
use ReflectionMethod;
use TCG\Voyager\FormFields\HandlerInterface;
use VoyagerRelationSelector\FormFields\RegionSelector;
use VoyagerRelationSelector\Models\Region;
use VoyagerRelationSelector\Tests\DatabaseTestCase;

class RegionSelectorTest extends DatabaseTestCase
{
    public function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }

    public function testInstanceof()
    {
        $this->assertEquals(true, app(RegionSelector::class) instanceof HandlerInterface);
    }

    /**
     * todo.
     */
    public function testCreateContentView()
    {
//        $row = new \stdClass();
//        $dataTypeContent = new \stdClass();
//        $options = new \stdClass();
//
//        $row->id = 22;
//        $dataTypeContent->exists = false;
//
//        $response = app(RegionSelector::class)->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
//        $testResponse = new TestResponse($response);
//
//        $view_options = new \stdClass();
//        $view_options->resources_url = '/vrs/region/__pid__';
//        $testResponse->assertViewHas('options', $view_options);
    }

    public function testGetLevel()
    {
        $fixture = app(RegionSelector::class);
        $reflector = new ReflectionMethod(RegionSelector::class, 'getLevel');

        $bar = $reflector->getClosure($fixture);
        $option = new \stdClass();
        $option->relation = [4];
        $bar = call_user_func_array($bar, [$option]);

        $this->assertEquals($bar, 2);

        $bar = $reflector->getClosure($fixture);
        $option = new \stdClass();
        $option->relation = [5, 66];
        $bar = call_user_func_array($bar, [$option]);

        $this->assertEquals($bar, 3);

        $bar = $reflector->getClosure($fixture);
        $option = new \stdClass();
        $option->level = 10;
        $bar = call_user_func_array($bar, [$option]);

        $this->assertEquals($bar, 10);

        $bar = $reflector->getClosure($fixture);
        $option = new \stdClass();
        $bar = call_user_func_array($bar, [$option]);

        $this->assertEquals($bar, 3);
    }

    public function testGetActiveValues()
    {
        $fixture = app(RegionSelector::class);
        $reflector = new ReflectionMethod(RegionSelector::class, 'getActiveValues');
        $getActiveValues = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = false;

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, []);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $dataTypeContent->foo = 12;
        $dataTypeContent->foo_key1 = 34;
        $options->relation = ['foo_key1'];
        $row->field = 'foo';

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, [34, 12]);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $dataTypeContent->foo = 12;
        $dataTypeContent->foo_key1 = 33;
        $dataTypeContent->foo_key2 = 45;
        $options->relation = ['foo_key1', 'foo_key2'];
        $row->field = 'foo';

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, [33, 45, 12]);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $dataTypeContent->foo = 12;
        $dataTypeContent->foo_key1 = 33;
        $dataTypeContent->foo_key2 = 45;
        $options->relation = ['foo_key1', 'foo_key3'];
        $row->field = 'foo';

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, [33, 12]);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $dataTypeContent->foo = 12;
        $dataTypeContent->foo_key1 = 33;
        $options->relation = ['foo_key1', 'foo_key2'];
        $row->field = 'foo';

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, [33, 12]);

        $mock = \Mockery::mock(Region::class);
        $mock->shouldReceive('getParents')
            ->andReturn([55, 33]);
        $fixture = new RegionSelector($mock);
        $reflector = new ReflectionMethod(RegionSelector::class, 'getActiveValues');
        $getActiveValues = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $row->field = 'foo';
        $dataTypeContent->foo = 12;

        $bar = call_user_func_array($getActiveValues, [$row, $dataTypeContent, $options]);
        $this->assertEquals($bar, [55, 33]);
    }
}
