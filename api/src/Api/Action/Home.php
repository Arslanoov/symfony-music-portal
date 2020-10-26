<?php

declare(strict_types=1);

namespace Api\Action;

use Http\Response\ResponseFactory;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Home
 * @package Api\Controller
 * @Route("/api", name="api", methods={"GET"})
 */
final class Home
{
    private ResponseFactory $response;

    /**
     * Home constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    public function __invoke()
    {
        return $this->response->json([
            'version' => '1.0'
        ]);
    }
}
