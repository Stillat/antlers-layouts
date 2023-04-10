<?php

namespace Stillat\AntlersLayouts;

use Statamic\Providers\AddonServiceProvider;
use Statamic\View\View;
use Stillat\AntlersLayouts\Tags\Layout;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Layout::class,
    ];

    public function bootAddon()
    {
        app()->resolving(View::class, function ($view) {
            Layout::$lastView = $view;
        });

        view()->composer(['layout', 'layouts/*'], function ($view) {
            $view->with(Layout::$variables);
            Layout::$variables = [];
        });
    }
}
