<?php

namespace VoyagerRelationSelector\Tests\FormFields;

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

    public function testCreateContentView()
    {
        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $row->id = 22;
        $row->field = 'test_field_name';
        $dataTypeContent->exists = false;

        $mock = \Mockery::mock(RegionSelector::class.'[getLevel, getActiveValues]', [new Region()]);
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('getLevel')->andReturn(2);
        $mock->shouldReceive('getActiveValues')->andReturn([23, 57]);

        $response = $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
        $this->assertStringContainsString('resources_url="/vrs/region/__pid__"', $response->render());

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $row->id = 22;
        $row->field = 'test_field_name';
        $dataTypeContent->exists = false;
        $options->resources_url = 'foo';

        config(['voyager.additional_js'=> []]);

        $response = $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
        $this->assertStringContainsString('resources_url="foo"', $response->render());
        $this->assertEquals(config('voyager.additional_js'), [
            'vrs/main.js?id=22&value=23,57',
        ]);
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
