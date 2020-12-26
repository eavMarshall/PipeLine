<?php

namespace PipeLine;

interface Pipable
{
    public function invoke(array $pipeResponses);
}