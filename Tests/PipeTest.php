<?php

namespace Tests;

use Di\DIContainer;
use PHPUnit\Framework\TestCase;
use PipeLine\Pipable;
use PipeLine\PipeLine;

class PipeTest extends TestCase
{
    private $container;

    public function getPipeLineInstance()
    {
        return $this->container->getInstanceOf(PipeLine::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new DIContainer();
    }

    public function testCreatePipe()
    {
        $pipeResults = $this->getPipeLineInstance()
            ->addPipes(
                SecurityPipable::class,
                RunFunction::class
            )
            ->execute();

        self::assertEquals('security checked', $pipeResults[SecurityPipable::class]);
        self::assertEquals('hello world', $pipeResults[RunFunction::class]);
    }
}

class SecurityPipable implements Pipable
{
    public function invoke(array $pipeResponses)
    {
        return 'security checked';
    }
}

class RunFunction implements Pipable
{
    public function invoke(array $pipeResponses)
    {
        return 'hello world';
    }
}