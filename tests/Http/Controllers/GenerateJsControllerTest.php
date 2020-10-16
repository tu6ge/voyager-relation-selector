<?php

namespace VoyagerRelationSelector\Tests\Http\Controllers;

use Illuminate\Testing\TestResponse;
use VoyagerRelationSelector\Http\Controllers\GenerateJsController;
use VoyagerRelationSelector\Tests\TestCase;

class GenerateJsControllerTest extends TestCase
{

    public function testIndex()
    {
        $controller = $this->app->make(GenerateJsController::class);

        $request = $this->app->request;
        $response = $controller->index($request);
        $testResponse = new TestResponse($response);

        $testResponse->assertViewIs('vrs::generate-js.index');

        $testResponse->assertViewHas('id', 0);
        $testResponse->assertViewHas('value', '[]');

        $request = $this->app->request;
        $request->offsetSet('id', 3);
        $request->offsetSet('value', '12');

        $response = $controller->index($request);

        $testResponse = new TestResponse($response);

        $testResponse->assertViewHas('id', 3);
        $testResponse->assertViewHas('value', '[12]');

        $request = $this->app->request;
        $request->offsetSet('id', 0);
        $request->offsetSet('value', '12,33');

        $response = $controller->index($request);

        $testResponse = new TestResponse($response);

        $testResponse->assertViewHas('id', 0);
        $testResponse->assertViewHas('value', '[12,33]');

        $testResponse->assertHeader('Content-Type', 'text/javascript');
    }
}
