<?php

namespace PipeLine;

interface Pipe
{
    public function invoke(array $pipeResponses);
}