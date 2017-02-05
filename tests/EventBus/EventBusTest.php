<?php

namespace DDDominio\Tests\EventBus;

use DDDominio\EventBus\EventBus;
use DDDominio\Tests\EventBus\TestData\DescriptionChanged;
use DDDominio\Tests\EventBus\TestData\DomainEvent;
use DDDominio\Tests\EventBus\TestData\FakeAnnotatedEventListener;
use DDDominio\Tests\EventBus\TestData\FakeEventListener;
use DDDominio\Tests\EventBus\TestData\NameChanged;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class EventBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    protected function setUp()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @test
     */
    public function handleDispatchedEvent()
    {
        $eventBus = new EventBus($this->annotationReader);
        $listener = new FakeEventListener();
        $eventBus->register($listener);
        $event = DomainEvent::record(new NameChanged('name'));

        $eventBus->dispatch($event);

        $this->assertCount(1, $listener->executedEventHandlers());
        $this->assertEquals('whenNameChanged', $listener->executedEventHandlers()[0]);
    }

    /**
     * @test
     */
    public function handleAnotherDispatchedEvent()
    {
        $eventBus = new EventBus($this->annotationReader);
        $listener = new FakeEventListener();
        $eventBus->register($listener);
        $event = DomainEvent::record(new DescriptionChanged('description'));

        $eventBus->dispatch($event);

        $this->assertCount(1, $listener->executedEventHandlers());
        $this->assertEquals('whenDescriptionChanged', $listener->executedEventHandlers()[0]);
    }

    /**
     * @test
     */
    public function handleDispatchedEventWithAnAnnotatedEventHandler()
    {
        $eventBus = new EventBus($this->annotationReader);
        $listener = new FakeAnnotatedEventListener();
        $eventBus->register($listener);
        $event = DomainEvent::record(new NameChanged('name'));

        $eventBus->dispatch($event);

        $this->assertCount(1, $listener->executedEventHandlers());
        $this->assertEquals('NameChanged', $listener->executedEventHandlers()[0]);
    }

    /**
     * @test
     */
    public function handleAnotherDispatchedEventWithAnAnnotatedEventHandler()
    {
        $eventBus = new EventBus($this->annotationReader);
        $listener = new FakeAnnotatedEventListener();
        $eventBus->register($listener);
        $event = DomainEvent::record(new DescriptionChanged('name'));

        $eventBus->dispatch($event);

        $this->assertCount(1, $listener->executedEventHandlers());
        $this->assertEquals('DescriptionChanged', $listener->executedEventHandlers()[0]);
    }
}
