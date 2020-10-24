<?php

declare(strict_types=1);

namespace Infrastructure\Http\Response;

use Http\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SymfonyHttpResponseFactory implements ResponseFactory
{
    public function json(array $content, int $code = 200): JsonResponse
    {
        return new JsonResponse($content, $code);
    }
}