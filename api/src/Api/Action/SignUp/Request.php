<?php

declare(strict_types=1);

namespace Api\Action\SignUp;

use Domain\Model\DomainException;
use Domain\Model\User\UseCase\SignUp\Request\Command;
use Domain\Model\User\UseCase\SignUp\Request\Handler;
use Http\Response\ResponseFactory;
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

        $id = Uuid::uuid4()->toString();
        $firstName = (string) ($body['first_name'] ?? '');
        $lastName = (string) ($body['last_name'] ?? '');
        $login = (string) ($body['login'] ?? '');
        $age = (int) ($body['age'] ?? 0);
        $email = (string) ($body['email'] ?? '');
        $password = (string) ($body['password'] ?? '');

        $signUpCommand = new Command($id, $firstName, $lastName, $login, $age, $email, $password);

        $violations = $this->validator->validate($signUpCommand);
        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            /** @var array $response */
            $response = json_decode($data, true);
            return $this->response->json($response, 422);
        }

        try {
            $this->handler->handle($signUpCommand);
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
