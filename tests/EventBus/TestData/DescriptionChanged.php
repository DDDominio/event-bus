<?php

namespace DDDominio\Tests\EventBus\TestData;

class DescriptionChanged
{
    /**
     * @var string
     */
    private $description;

    /**
     * @param string $description
     */
    public function __construct($description)
    {
        $this->$description = $description;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }
}
