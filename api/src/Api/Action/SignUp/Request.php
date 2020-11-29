<?php

declare(strict_types=1);

namespace Api\Action\SignUp;

use Domain\Model\DomainException;
use Domain\Model\Music\Artist\UseCase\Create\Command as ArtistCommand;
use Domain\Model\Music\Artist\UseCase\Create\Handler as ArtistHandler;
use Domain\Model\User\UseCase\SignUp\Request\Command as UserCommand;
use Domain\Model\User\UseCase\SignUp\Request\Handler as UserHandler;
use Http\Response\ResponseFactory;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Request
 * @package Api\Action\SignUp
 * @Route("/api/sign-up", name="api.sign-up", methods={"POST"})
 * @OA\Post(
 *     path="/auth/sign-up",
 *     tags={"Sign Up Request"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"first_name", "last_name", "login", "email", "age", "password"},
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="login", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="age", type="integer"),
 *             @OA\Property(property="password", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Success response",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(property="email", type="string", nullable=false)
 *             )
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
    private UserHandler $userHandler;
    private ArtistHandler $artistHandler;
    private ResponseFactory $response;

    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        UserHandler $userHandler,
        ArtistHandler $artistHandler,
        ResponseFactory $response
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->userHandler = $userHandler;
        $this->artistHandler = $artistHandler;
        $this->response = $response;
    }

    public function __invoke(HttpRequest $request)
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var array $body */
        $body = json_decode($content, true);

        $id = Uuid::uuid4()->toString();
        $firstName = (string) ($body['first_name'] ?? '');
        $lastName = (string) ($body['last_name'] ?? '');
        $login = (string) ($body['login'] ?? '');
        $age = (int) ($body['age'] ?? 0);
        $email = (string) ($body['email'] ?? '');
        $password = (string) ($body['password'] ?? '');

        $signUpCommand = new UserCommand($id, $firstName, $lastName, $login, $age, $email, $password);
        $createArtistCommand = new ArtistCommand($id, $login);

        $violations = $this->validator->validate($signUpCommand);

        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            /** @var array $response */
            $response = json_decode($data, true);
            return $this->response->json($response, 422);
        }

        try {
            $this->userHandler->handle($signUpCommand);
            $this->artistHandler->handle($createArtistCommand);
        } catch (DomainException $e) {
            $this->logger->debug($e->getMessage(), ['exception' => $e]);
            return $this->response->json([
                'message' => $e->getMessage()
            ], (int) $e->getCode());
        }

        return $this->response->json([
            'email' => $email
        ], 201);
    }
}
