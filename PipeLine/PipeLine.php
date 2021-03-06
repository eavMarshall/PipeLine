<?php

namespace PipeLine;

use Di\DIContainer;

class PipeLine
{
    private $container;
    private $pipes = [];

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param string ...$pipes
     * @return $this
     */
    public function addPipes(string ...$pipes)
    {
        $this->pipes = array_merge($this->pipes, $pipes);

        return $this;
    }

    /**
     * @return string[]
     */
    public function execute(): array
    {
        $pipeResults = [];
        foreach ($this->pipes as $pipeClass) {
            /** @var Pipable $pipe */
            $pipe = $this->container->getInstanceOf($pipeClass);
            $pipeResults[$pipeClass] = $pipe->invoke($pipeResults);
        }
        return $pipeResults;
    }
}