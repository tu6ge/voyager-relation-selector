<?php

namespace VoyagerRelationSelector\Tests\FormFields;

use Illuminate\Database\Eloquent\Model;
use ReflectionMethod;
use VoyagerRelationSelector\Exceptions\RelationSelectorException;
use VoyagerRelationSelector\FormFields\RelationSelector;
use VoyagerRelationSelector\Tests\DatabaseTestCase;
use VoyagerRelationSelector\Tests\Models\FooModelHasTrait;

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

    public function testLevel()
    {
        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $row->id = 22;
        $row->field = 'test_field_name';
        $dataTypeContent->exists = false;
        $options->relation = ['first_foo', 'second_foo'];
        $options->resources_url = 'test_url';

        $mock = \Mockery::mock(RelationSelector::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('getSelectedValue')->andReturn([238, 57]);

        $response = $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
        $this->assertStringContainsString('name="test_field_name"  :value="value_level_2', $response->render());

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $row->id = 22;
        $row->field = 'test_field_name';
        $dataTypeContent->exists = false;
        $options->model = 'test_model';
        $options->resources_url = 'test_url';
        $options->level = 10;

        $mock = \Mockery::mock(RelationSelector::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('getSelectedValue')->andReturn([238, 57]);

        $response = $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
        $this->assertStringContainsString('name="test_field_name"  :value="value_level_9', $response->render());
    }

    public function testExceptionLevel()
    {
        $class = new RelationSelector();

        $row = new \stdClass();
        $dataType = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = collect();
        $options->model = 'bar';
        $options->resources_url = 'bar';

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('option level is not found');

        $class->createContent($row, $dataType, $dataTypeContent, $options);
    }
    
    public function testGetSelectedValue()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = false;
        $testValue = call_user_func_array($closure, [$row, $dataTypeContent, $options]);
        $this->assertEquals($testValue, []);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $options->relation = ['first_field', 'second_field'];
        $dataTypeContent->first_field = 13;
        $dataTypeContent->second_field = 34;
        $dataTypeContent->foo_field = 90;
        $row->field = 'foo_field';
        $testValue = call_user_func_array($closure, [$row, $dataTypeContent, $options]);
        $this->assertEquals($testValue, [13, 34, 90]);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();
        $dataTypeContent->exists = true;
        $row->field = 'foo_field';
        $dataTypeContent->foo_field = 'foo_value';
        $mock = \Mockery::mock(FooModelHasTrait::class);
        $mock->shouldReceive('getParents')
            ->once()
            ->with('foo_value')
            ->andReturn([55, 33]);
        $mockThis = \Mockery::mock(RelationSelector::class)->makePartial();
        $mockThis->shouldAllowMockingProtectedMethods();
        $mockThis->shouldReceive('checkModel')->andReturnNull();
        $mockThis->shouldReceive('instanceModel')->andReturn($mock);

        $options->model = FooModelHasTrait::class;
        $testValue = $mockThis->getSelectedValue($row, $dataTypeContent, $options);
        $this->assertEquals($testValue, [55, 33]);
    }

    public function testExceptionGetSelectedValue()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $dataTypeContent->exists = true;
        $options->relation = ['first_field', 'second_field'];
        $dataTypeContent->second_field = 34;
        $dataTypeContent->foo_field = 90;
        $row->field = 'foo_field';

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('the field first_field is not found in dataTypeContent');

        call_user_func_array($closure, [$row, $dataTypeContent, $options]);
    }

    public function testExceptionModelExists()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $dataTypeContent->exists = true;

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('options model :  is not a class');

        call_user_func_array($closure, [$row, $dataTypeContent, $options]);
    }

    public function testExceptionModelExistsSecond()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $dataTypeContent->exists = true;
        $options->model = 'bar_model';

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('options model : bar_model is not a class');

        call_user_func_array($closure, [$row, $dataTypeContent, $options]);
    }

    public function testExceptionModelValid()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $dataTypeContent->exists = true;
        $options->model = Foo::class;

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('options model : VoyagerRelationSelector\Tests\FormFields\Foo is not instance of Illuminate\Database\Eloquent\Model');

        call_user_func_array($closure, [$row, $dataTypeContent, $options]);
    }

    public function testCheckModel()
    {
        $fixture = new RelationSelector();
        $reflector = new ReflectionMethod(RelationSelector::class, 'getSelectedValue');
        $closure = $reflector->getClosure($fixture);

        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $dataTypeContent->exists = true;
        $options->model = FooModel::class;

        $this->expectException(RelationSelectorException::class);
        $this->expectExceptionMessage('options model : VoyagerRelationSelector\Tests\FormFields\FooModel have not getParents method');

        call_user_func_array($closure, [$row, $dataTypeContent, $options]);
    }

    public function testCreateContentView()
    {
        $row = new \stdClass();
        $dataTypeContent = new \stdClass();
        $options = new \stdClass();

        $row->id = 22;
        $row->field = 'test_field_name';
        $dataTypeContent->exists = false;
        $options->relation = ['first_foo', 'second_foo'];
        $options->resources_url = 'test_url';

        $mock = \Mockery::mock(RelationSelector::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('getSelectedValue')->andReturn([238, 57]);

        config(['voyager.additional_js'=> []]);

        $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
        $this->assertEquals(config('voyager.additional_js'), [
            'vrs/main.js?id=22&value=238,57',
        ]);
    }

//    public function testView()
//    {
//        $row = new \stdClass();
//        $dataTypeContent = new \stdClass();
//        $options = new \stdClass();
//
//        $row->id = 22;
//        $row->field = 'test_field_name';
//        $dataTypeContent->exists = false;
//        $options->relation = ['first_foo', 'second_foo'];
//        $options->resources_url = 'test_url';
//
//        $mock = \Mockery::mock(RelationSelector::class)->makePartial();
//        $mock->shouldAllowMockingProtectedMethods();
//        $mock->shouldReceive('getSelectedValue')->andReturn([238, 57]);
//
//        $response = $mock->createContent($row, $dataType = 'bar', $dataTypeContent, $options);
//        $this->assertStringContainsString('id="relation_selector_22', $response->render());
//        $this->assertStringContainsString('relation-selector :level="3" v-model="value"', $response->render());
//        $this->assertStringContainsString('resources_url="test_url"', $response->render());
//    }
}

class Foo
{
}

class FooModel extends Model
{
}
