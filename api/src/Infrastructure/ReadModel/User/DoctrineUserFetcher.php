<?php

declare(strict_types=1);

namespace Infrastructure\ReadModel\User;

use Api\ReadModel\User\AuthView;
use Api\ReadModel\User\UserFetcher;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Model\User\User;

final class DoctrineUserFetcher implements UserFetcher
{
    private Connection $connection;
    private EntityRepository $repository;

    /**
     * UserFetcher constructor.
     * @param Connection $connection
     * @param EntityManagerInterface $em
     */
    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(User::class);
    }

    public function findForAuthByEmail(string $email): ?AuthView
    {
        // TODO: Fetch mode is deprecated

        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'login',
                'email',
                'password',
                'status'
            )
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthView::class);

        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findForAuthByLogin(string $login): ?AuthView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'login',
                'email',
                'password',
                'status',
                'avatar'
            )
            ->from('user_users')
            ->where('login = :login')
            ->setParameter(':login', $login)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }
}