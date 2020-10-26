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
        $body = json_decode($request->getContent(), true);
        $id = Uuid::uuid4()->toString();

        $signUpCommand = new Command(
            $id,
            $firstName = $body['first_name'] ?? '',
            $lastName = $body['last_name'] ?? '',
            $login = $body['login'] ?? '',
            $age = (int) $body['age'] ?? 0,
            $email = $body['email'] ?? '',
            $password = $body['password']
        );

        $violations = $this->validator->validate($signUpCommand);
        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            return $this->response->json(json_decode($data, true), 422);
        }

        try {
            $this->handler->handle($signUpCommand);
        } catch (DomainException $e) {
            $this->logger->debug($e->getMessage(), ['exception' => $e]);
            return $this->response->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return $this->response->json([
            'email' => $email
        ], 201);
    }
}
