<?php

namespace VoyagerRelationSelector;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
use VoyagerRelationSelector\FormFields\RegionSelector;
use VoyagerRelationSelector\FormFields\RelationSelector;
use VoyagerRelationSelector\FormFields\RelationSelectorParent;

class VoyagerRelationSelectorServiceProvider extends ServiceProvider
{
    public function register()
    {
        Voyager::addFormField(RegionSelector::class);

        Voyager::addFormField(RelationSelector::class);

        Voyager::addFormField(RelationSelectorParent::class);
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'voyager_relation_selector');

        $this->additional_css_js();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vrs');
    }

    protected function additional_css_js()
    {
        //Toolkit::append_css('https://unpkg.com/element-ui/lib/theme-chalk/index.css');

        Toolkit::append_js('vendor/voyager-relation-selector/js/app.js');
    }
}
