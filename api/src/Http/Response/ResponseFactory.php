<?php

declare(strict_types=1);

namespace Http\Response;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseFactory
{
    /**
     * @param array $content
     * @param int $code
     * @return JsonResponse|ResponseInterface
     */
    public function json(array $content, int $code = 200);
}
