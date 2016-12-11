<?php

namespace EventBus;

use Common\Event;

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
     * @param Event $event
     * @return string[]
     */
    public function getHandlersFor(EventListener $eventListener, $event)
    {
        $eventListenerName = get_class($eventListener);
        $eventName = get_class($event);
        return isset($this->eventHandlersRegistry[$eventListenerName][$eventName]) ?
            $this->eventHandlersRegistry[$eventListenerName][$eventName] : [];
    }
}
