<?php

namespace DDDominio\Tests\EventBus\TestData;

use DDDominio\EventBus\EventListener;

class FakeEventListener implements EventListener
{
    /**
     * @var array
     */
    private $executedEventHandlers;

    public function __construct()
    {
        $this->executedEventHandlers = [];
    }

    /**
     * @param NameChanged $event
     */
    public function whenNameChanged(NameChanged $event)
    {
        $this->executedEventHandlers[] = 'whenNameChanged';
    }

    /**
     * @param DescriptionChanged $event
     */
    public function whenDescriptionChanged(DescriptionChanged $event)
    {
        $this->executedEventHandlers[] = 'whenDescriptionChanged';
    }

    /**
     * @return array
     */
    public function executedEventHandlers()
    {
        return $this->executedEventHandlers;
    }
}
