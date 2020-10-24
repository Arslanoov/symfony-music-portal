<?php

declare(strict_types=1);

namespace Http\Response;

interface ResponseFactory
{
    public function json(array $content, int $code = 200);
}