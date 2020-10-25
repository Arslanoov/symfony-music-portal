<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Model\User\Email;
use Domain\Model\User\Exception\UserNotFoundException;
use Domain\Model\User\Login;
use Domain\Model\User\User;
use Domain\Model\User\UserRepository;

final class DoctrineUserRepository implements UserRepository
{
    private EntityRepository $repository;
    private EntityManagerInterface $em;

    /**
     * DoctrineUserRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(User::class);
        $this->em = $em;
    }

    public function findByLogin(Login $login): ?User
    {
        /** @var User|null $user */
        $user = $this->repository->findOneBy([
            'login' => $login->getValue()
        ]);

        return $user;
    }

    public function getByLogin(Login $login): User
    {
        if (!$user = $this->findByLogin($login)) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function findByEmail(Email $email): ?User
    {
        /** @var User|null $user */
        $user = $this->repository->findOneBy([
            'email' => $email->getValue()
        ]);

        return $user;
    }

    public function getByEmail(Email $email): User
    {
        if (!$user = $this->findByEmail($email)) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}