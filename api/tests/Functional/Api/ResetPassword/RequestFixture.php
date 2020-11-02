<?php

declare(strict_types=1);

namespace Test\Functional\Api\ResetPassword;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Test\Builder\UserBuilder;

final class RequestFixture extends Fixture
{
    public const NOT_REQUESTED_REFERENCE = 'test_reset_password_request_not_requested';

    public function load(ObjectManager $manager): void
    {
        $notRequested = (new UserBuilder())
            ->withLogin('successLogin')
            ->withEmail('success@user.com')
            ->build();

        $manager->persist($notRequested);

        $this->setReference(self::NOT_REQUESTED_REFERENCE, $notRequested);

        $manager->flush();
    }
}