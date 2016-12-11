<?php

namespace Tests\EventBus\TestData;

use Common\Event;

class DescriptionChanged implements Event
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @param string $description
     * @param \DateTimeImmutable $occurredOn
     */
    public function __construct($description, \DateTimeImmutable $occurredOn)
    {
        $this->$description = $description;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
