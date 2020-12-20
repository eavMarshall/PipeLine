<?php

namespace PipeLine;

use Di\DIContainer;

class PipeLine
{
    private $container;

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    public function pipe(string ...$pipes)
    {
        $responses = [];
        foreach ($pipes as $pipeClass) {
            /** @var Pipe $pipe */
            $pipe = $this->container->getInstanceOf($pipeClass);
            $responses[$pipeClass] = $pipe->invoke($responses);
        }
        return $responses;
    }
}