<?php

namespace Tests;

use Di\DIContainer;
use PHPUnit\Framework\TestCase;
use PipeLine\Pipe;
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
        $response = $this->getPipeLineInstance()
            ->pipe(
                SecurityPipe::class,
                RunFunction::class
            );

        self::assertEquals('security checked', $response[SecurityPipe::class]);
        self::assertEquals('hello world', $response[RunFunction::class]);
    }
}

class SecurityPipe implements Pipe
{
    public function invoke(array $pipeResponses)
    {
        return 'security checked';
    }
}

class RunFunction implements Pipe
{
    public function invoke(array $pipeResponses)
    {
        return 'hello world';
    }
}