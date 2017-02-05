<?php

namespace DDDominio\EventBus;

use DDDominio\Common\EventInterface;
use DDDominio\EventBus\Annotation\EventHandler;
use Doctrine\Common\Annotations\AnnotationReader;

class EventBus
{
    /**
     * @var EventListener[]
     */
    private $eventListeners;

    /**
     * @var EventHandlersRegistry
     */
    private $eventHandlersRegistry;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->eventListeners = [];
        $this->eventHandlersRegistry = [];
        $this->eventHandlersRegistry = new EventHandlersRegistry();
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param EventListener $eventListener
     */
    public function register(EventListener $eventListener)
    {
        $this->eventListeners[] = $eventListener;

        $reflectedClass = new \ReflectionClass(get_class($eventListener));
        $methods = $reflectedClass->getMethods();
        foreach ($methods as $method) {
            $parameters = $method->getParameters();
            if (count($parameters) === 1) {
                $annotation = $this->annotationReader->getMethodAnnotation($method, EventHandler::class);
                if ($annotation instanceof EventHandler) {
                    $event = $parameters[0];
                    $this->eventHandlersRegistry->registerEventHandler(
                        get_class($eventListener),
                        $event->getClass()->getName(),
                        $method->getName()
                    );
                } else if (strpos($method->getName(), 'when') === 0) {
                    $event = $parameters[0];
                    $eventName = $event->getClass()->getShortName();
                    $eventHandlerName = 'when' . $eventName;
                    if (method_exists($eventListener, $eventHandlerName)) {
                        $this->eventHandlersRegistry->registerEventHandler(
                            get_class($eventListener),
                            $event->getClass()->getName(),
                            $eventHandlerName
                        );
                    }
                }
            }
        }
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event)
    {
        foreach ($this->eventListeners as $eventListener) {
            $eventHandlerNames = $this->eventHandlersRegistry->getHandlersFor($eventListener, $event);
            foreach ($eventHandlerNames as $eventHandlerName) {
                $eventListener->{$eventHandlerName}($event->data());
            }
        }
    }
}
