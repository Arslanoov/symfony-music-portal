<?php

declare(strict_types=1);

namespace Test\Functional\Api\Auth;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Test\Builder\UserBuilder;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;
use Trikoder\Bundle\OAuth2Bundle\OAuth2Grants;

final class OAuthFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new UserBuilder())
            ->withEmail('oauth-password-user@app.test')
            ->withLogin('OAuth User')
            ->withPassword('$2y$12$qwnND33o8DGWvFoepotSju7eTAQ6gzLD/zy6W8NCVtiHPbkybz.w6') // password
            ->active()
            ->build();

        $manager->persist($user);

        $client = new Client('oauth', 'secret');
        $client->setGrants(new Grant(OAuth2Grants::PASSWORD));

        $manager->persist($client);

        $manager->flush();
    }
}