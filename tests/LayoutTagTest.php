<?php

namespace Tests;

use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Stillat\AntlersLayouts\Tags\Layout;

class LayoutChangeTest extends BaseTestCase
{
    use FakesViews;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createCollectionAndEntries();
    }

    private function createCollectionAndEntries()
    {
        $collection = Collection::make('test')->routes('{slug}')->save();
        $collection->save();

        Entry::make()->collection('test')->slug('test')->data(['title' => 'Test'])->save();
    }

    private function createFakeViews()
    {
        $this->withFakeViews();

        $this->viewShouldReturnRaw('layout', 'The default layout: {{ template_content }}');
        $this->viewShouldReturnRaw('layouts/one', 'I am layout one: {{ template_content }}');
        $this->viewShouldReturnRaw('layouts/two', 'I am layout two: {{ template_content }}');
    }

    public function testLayoutsCanBeChanged()
    {
        $this->createFakeViews();
        Layout::register();

        $this->viewShouldReturnRaw('default', 'The default template content.');

        $this->get('test')->assertOk()
            ->assertSee('The default layout: The default template content.');

        $this->viewShouldReturnRaw('default', '{{ layout layout="layouts/one" }} Custom Content');

        $this->get('test')->assertOk()
            ->assertSee('I am layout one:  Custom Content');

        $this->viewShouldReturnRaw('default', '{{ layout:layouts/two }} Custom Content');

        $this->get('test')->assertOk()
            ->assertSee('I am layout two:  Custom Content');
    }

    public function testVariablesCanBeSharedWithLayouts()
    {
        $this->createFakeViews();
        Layout::register();

        $this->viewShouldReturnRaw('default', '{{ layout:layouts/test-layout }} Content {{ layout:share custom_var="Hello" }}');
        $this->get('test')->assertOk()
            ->assertSee('Test Layout:  Content  -- Hello');

        $this->viewShouldReturnRaw('default', '{{ layout:layouts/test-layout }} Content');

        $this->get('test')->assertOk()
            ->assertSee('Test Layout:  Content --');
    }
}
