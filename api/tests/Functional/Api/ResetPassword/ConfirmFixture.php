<?php

declare(strict_types=1);

namespace Test\Functional\Api\ResetPassword;

use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Test\Builder\UserBuilder;

final class ConfirmFixture extends Fixture
{
    public const REQUESTED_REFERENCE = 'test_reset_password_change_requested';
    public const EXPIRED_REFERENCE = 'test_reset_password_change_expired';

    public function load(ObjectManager $manager): void
    {
        $requested = (new UserBuilder())
            ->withLogin('requestedLogin')
            ->withEmail('requested@user.com')
            ->withResetPasswordConfirmToken(
                'requested',
                (new DateTimeImmutable())->add(new DateInterval('PT1H'))
            )
            ->build();

        $manager->persist($requested);

        $expired = (new UserBuilder())
            ->withLogin('expiredPLogin')
            ->withEmail('expiredP@user.com')
            ->withResetPasswordConfirmToken('expired', (new DateTimeImmutable())->modify('-1 day'))
            ->build();

        $manager->persist($expired);

        $this->setReference(self::REQUESTED_REFERENCE, $requested);
        $this->setReference(self::EXPIRED_REFERENCE, $expired);

        $manager->flush();
    }
}