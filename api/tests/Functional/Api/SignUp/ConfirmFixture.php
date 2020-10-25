<?php

declare(strict_types=1);

namespace Test\Functional\Api\SignUp;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Model\User\Age;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Email;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\Password;
use Domain\Model\User\User;

final class ConfirmFixture extends Fixture
{
    public const SUCCESS_REFERENCE = 'test_sign_up_confirm_success';
    public const EXPIRED_REFERENCE = 'test_sign_up_confirm_expired';

    public function load(ObjectManager $manager): void
    {
        $notConfirmed = User::signUpByEmail(
            Id::asUuid4(),
            new Name('name', 'name'),
            new Login('someUserLogin'),
            new Email('someUser@app.test'),
            new Age(25),
            new Password('secret'),
            new ConfirmToken('success_token', (new DateTimeImmutable())->modify('+1 hour'))
        );

        $manager->persist($notConfirmed);

        $expired = User::signUpByEmail(
            Id::asUuid4(),
            new Name('name', 'name'),
            new Login('expiredLogin'),
            new Email('expired@app.test'),
            new Age(25),
            new Password('secret'),
            new ConfirmToken('expired_token', (new DateTimeImmutable())->modify('-1 hour'))
        );

        $manager->persist($expired);

        $this->setReference(self::SUCCESS_REFERENCE, $notConfirmed);
        $this->setReference(self::EXPIRED_REFERENCE, $expired);

        $manager->flush();
    }
}