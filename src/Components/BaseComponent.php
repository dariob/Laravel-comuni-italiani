<?php

namespace DarioBarila\ComuniItaliani\Components;

use Livewire\Component;

abstract class BaseComponent extends Component
{
    protected function getComponentClasses(string $type): string
    {
        return config('comuni-italiani.component_classes.' . $type, '');
    }

    protected function getWrapperClass(): string
    {
        return $this->getComponentClasses('wrapper');
    }

    protected function getLabelClass(): string
    {
        return $this->getComponentClasses('label');
    }

    protected function getSelectClass(): string
    {
        return $this->getComponentClasses('select');
    }
}
