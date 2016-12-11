<?php

namespace Tests\EventBus\TestData;

use EventBus\Event;

class NameChanged implements Event
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @param string $name
     * @param \DateTimeImmutable $occurredOn
     */
    public function __construct($name, \DateTimeImmutable $occurredOn)
    {
        $this->name = $name;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
