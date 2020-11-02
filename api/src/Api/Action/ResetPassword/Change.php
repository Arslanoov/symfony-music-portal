<?php

declare(strict_types=1);

namespace Api\Action\ResetPassword;

use Domain\Model\User\UseCase\ResetPassword\Change\Command;
use Domain\Model\User\UseCase\ResetPassword\Change\Handler;
use Domain\Model\DomainException;
use Http\Response\ResponseFactory;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Change
 * @package Api\Action\ResetPassword
 * @Route("/api/reset-password/change", name="api.reset-password.change", methods={"POST"})
 * @OA\Post(
 *     path="/reset-password/change",
 *     tags={"Reset Password - Change password"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"login", "token", "new_password"},
 *             @OA\Property(property="login", type="string"),
 *             @OA\Property(property="token", type="string"),
 *             @OA\Property(property="new_password", type="string")
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
final class Change
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private Handler $handler;
    private ResponseFactory $response;

    /**
     * Change constructor.
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
        $token = (string) ($body['token'] ?? '');
        $newPassword = (string) ($body['new_password'] ?? '');

        $command = new Command($login, $token, $newPassword);

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

        return $this->response->json([], 204);
    }
}
