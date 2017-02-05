<?php

namespace DDDominio\EventBus;

use DDDominio\Common\EventInterface;

class EventHandlersRegistry
{
    /**
     * @var array
     */
    private $eventHandlersRegistry = [];

    /**
     * @param string $listenerName
     * @param string $eventName
     * @param string $methodName
     */
    public function registerEventHandler($listenerName, $eventName, $methodName)
    {
        $this->eventHandlersRegistry[$listenerName][$eventName][] = $methodName;
    }

    /**
     * @param EventListener $eventListener
     * @param EventInterface $event
     * @return string[]
     */
    public function getHandlersFor(EventListener $eventListener, EventInterface $event)
    {
        $eventListenerName = get_class($eventListener);
        $eventName = get_class($event->data());
        return isset($this->eventHandlersRegistry[$eventListenerName][$eventName]) ?
            $this->eventHandlersRegistry[$eventListenerName][$eventName] : [];
    }
}
