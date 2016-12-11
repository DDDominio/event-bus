<?php

namespace Tests\EventBus;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use EventBus\EventBus;
use Tests\EventBus\TestData\DescriptionChanged;
use Tests\EventBus\TestData\FakeAnnotatedEventListener;
use Tests\EventBus\TestData\FakeEventListener;
use Tests\EventBus\TestData\NameChanged;

class EventBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    protected function setUp()
    {
        AnnotationRegistry::registerAutoloadNamespace('EventBus\Annotation', __DIR__ . '/../../src');
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
        $event = new NameChanged('name', new \DateTimeImmutable());

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
        $event = new DescriptionChanged('description', new \DateTimeImmutable());

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
        $event = new NameChanged('name', new \DateTimeImmutable());

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
        $event = new DescriptionChanged('name', new \DateTimeImmutable());

        $eventBus->dispatch($event);

        $this->assertCount(1, $listener->executedEventHandlers());
        $this->assertEquals('DescriptionChanged', $listener->executedEventHandlers()[0]);
    }
}
