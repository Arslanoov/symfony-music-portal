<?php

declare(strict_types=1);

namespace Api\Action\SignUp;

use Domain\Model\DomainException;
use Domain\Model\User\UseCase\SignUp\Confirm\Command;
use Domain\Model\User\UseCase\SignUp\Confirm\Handler;
use Http\Response\ResponseFactory;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Confirm
 * @package Api\Action\SignUp
 * @Route("/api/sign-up/confirm/{token}", name="api.sign-up.confirm", methods={"POST"})
 * @OA\Post(
 *     path="/auth/sign-up/confirm",
 *     tags={"Sign Up Confirm"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"token"},
 *             @OA\Property(property="token", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Success response"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Errors",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=419,
 *         description="Domain errors",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", nullable=true)
 *         )
 *     )
 * )
 */
final class Confirm
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private Handler $handler;
    private ResponseFactory $response;

    /**
     * Confirm constructor.
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     * @param Handler $handler
     * @param ResponseFactory $response
     */
    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        Handler $handler,
        ResponseFactory $response
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->handler = $handler;
        $this->response = $response;
    }

    public function __invoke(Request $request, string $token)
    {
        $confirmCommand = new Command($token);

        $violations = $this->validator->validate($confirmCommand);
        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            /** @var array $response */
            $response = json_decode($data, true);
            return $this->response->json($response, 422);
        }

        try {
            $this->handler->handle($confirmCommand);
        } catch (DomainException $e) {
            $this->logger->debug($e->getMessage(), ['exception' => $e]);
            return $this->response->json([
                'message' => $e->getMessage()
            ], (int) $e->getCode());
        }

        return $this->response->json([], 204);
    }
}
