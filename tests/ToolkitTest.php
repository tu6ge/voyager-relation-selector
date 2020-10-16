<?php
/**
 * Created by PhpStorm.
 * User: ZHIYUAN
 * Date: 2020-10-16
 * Time: 16:28
 */
namespace VoyagerRelationSelector\Tests;

use Illuminate\Support\Facades\Config;
//use PHPUnit\Framework\TestCase;
use Orchestra\Testbench\TestCase;
use TCG\Voyager\VoyagerServiceProvider;
use VoyagerRelationSelector\Toolkit;

class ToolkitTest extends TestCase
{
    public function test_append_js()
    {
        Config::set(['voyager.additional_js'=>[]]);

        $this->assertEquals([], Config::get('voyager.additional_js'));

        Toolkit::append_js('bar');

        $this->assertEquals(['bar'], Config::get('voyager.additional_js'));

        Toolkit::append_js('foo');

        $this->assertEquals(['bar','foo'], Config::get('voyager.additional_js'));
    }

    public function test_append_css()
    {
        Config::set(['voyager.additional_css'=>[]]);

        $this->assertEquals([], Config::get('voyager.additional_css'));

        Toolkit::append_css('bar');

        $this->assertEquals(['bar'], Config::get('voyager.additional_css'));

        Toolkit::append_css('foo');

        $this->assertEquals(['bar','foo'], Config::get('voyager.additional_css'));
    }
}