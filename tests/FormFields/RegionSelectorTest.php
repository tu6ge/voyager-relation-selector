<?php
/**
 * Created by PhpStorm.
 * User: ZHIYUAN
 * Date: 2020-10-16
 * Time: 15:54
 */
namespace VoyagerRelationSelector\Tests\FormFields;

use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\TestCase;
use TCG\Voyager\FormFields\HandlerInterface;
use VoyagerRelationSelector\FormFields\RegionSelector;

class RegionSelectorTest extends TestCase
{
    public function testInstanceof()
    {
        $this->assertEquals(true, app(RegionSelector::class) instanceof HandlerInterface);
    }

//    public function testCreateContentView()
//    {
//        $row = new \stdClass();
//        $row->
//        $response = app(RegionSelector::class)->createContent();
//    }
}