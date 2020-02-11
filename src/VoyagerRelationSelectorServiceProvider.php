<?php 

namespace VoyagerRelationSelector;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use TCG\Voyager\Facades\Voyager;
use VoyagerRelationSelector\FormFields\RelationSelector;

class VoyagerRelationSelectorServiceProvider extends ServiceProvider
{
    public function register()
    {
        Voyager::addFormField(RelationSelector::class);
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'voyager_relation_selector');
    }
}