<?php

namespace Stillat\AntlersLayouts\Tags;

use Statamic\Tags\Tags;
use Statamic\View\State\ResetsState;

class Layout extends Tags implements ResetsState
{
    public static $lastView = null;

    public static $variables = [];

    public function index()
    {
        $this->setLayout($this->params->get('layout'));
    }

    protected function setLayout($layout)
    {
        if (self::$lastView != null) {
            self::$lastView->layout($layout);
        }
    }

    public function share()
    {
        self::$variables = array_merge(self::$variables, $this->params->all());
    }

    public function wildcard($tag)
    {
        $this->setLayout($tag);
    }

    public static function resetStaticState()
    {
        self::$lastView = null;
        self::$variables = [];
    }
}
