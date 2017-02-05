<?php

namespace DDDominio\Tests\EventBus\TestData;

use DDDominio\Common\EventInterface;

class DomainEvent implements EventInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var mixed
     */
    private $metadata;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @param mixed $data
     * @param mixed $metadata
     * @param \DateTimeImmutable $occurredOn
     */
    public function __construct($data, $metadata, \DateTimeImmutable $occurredOn)
    {
        $this->data = $data;
        $this->metadata = $metadata;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @param mixed $data
     * @return DomainEvent
     */
    public static function record($data)
    {
        return new self($data, [], new \DateTimeImmutable());
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function metadata()
    {
        return $this->metadata;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
