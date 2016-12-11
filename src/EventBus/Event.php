<?php

namespace EventBus;

interface Event
{
    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn();
}
