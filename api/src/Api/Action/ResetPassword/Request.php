<?php

declare(strict_types=1);

namespace Api\Action\ResetPassword;

use Domain\Model\User\UseCase\ResetPassword\Request\Command;
use Domain\Model\User\UseCase\ResetPassword\Request\Handler;
use Domain\Model\DomainException;
use Http\Response\ResponseFactory;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Request
 * @package Api\Action\ResetPassword
 * @Route("/api/reset-password", name="api.reset-password", methods={"POST"})
 * @OA\Post(
 *     path="/reset-password",
 *     tags={"Reset Password Request"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"login", "email"},
 *             @OA\Property(property="login", type="string"),
 *             @OA\Property(property="email", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", nullable=false)
 *         )
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
final class Request
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private Handler $handler;
    private ResponseFactory $response;

    /**
     * Request constructor.
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

    public function __invoke(HttpRequest $request)
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var array $body */
        $body = json_decode($content, true);

        $login = (string) ($body['login'] ?? '');
        $email = (string) ($body['email'] ?? '');

        $command = new Command($login, $email);

        $violations = $this->validator->validate($command);
        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            /** @var array $response */
            $response = json_decode($data, true);
            return $this->response->json($response, 422);
        }

        try {
            $this->handler->handle($command);
        } catch (DomainException $e) {
            $this->logger->debug($e->getMessage(), ['exception' => $e]);
            return $this->response->json([
                'message' => $e->getMessage()
            ], (int) $e->getCode());
        }

        return $this->response->json([
            'email' => $email
        ], 200);
    }
}
