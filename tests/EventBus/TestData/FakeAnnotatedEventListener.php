<?php

namespace DDDominio\Tests\EventBus\TestData;

use DDDominio\EventBus\Annotation\EventHandler;
use DDDominio\EventBus\EventListener;

class FakeAnnotatedEventListener implements EventListener
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
     * @EventHandler()
     */
    public function nameChangedHandler(NameChanged $event)
    {
        $this->executedEventHandlers[] = 'NameChanged';
    }

    /**
     * @param DescriptionChanged $event
     * @EventHandler()
     */
    public function descriptionChangedHandler(DescriptionChanged $event)
    {
        $this->executedEventHandlers[] = 'DescriptionChanged';
    }

    /**
     * @return array
     */
    public function executedEventHandlers()
    {
        return $this->executedEventHandlers;
    }
}
