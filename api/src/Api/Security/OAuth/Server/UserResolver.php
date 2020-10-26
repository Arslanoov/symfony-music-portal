<?php

declare(strict_types=1);

namespace Api\Security\OAuth\Server;

use Domain\Model\User\Service\PasswordValidator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;
use Trikoder\Bundle\OAuth2Bundle\OAuth2Events;

final class UserResolver implements EventSubscriberInterface
{
    private UserProviderInterface $userProvider;
    private PasswordValidator $validator;

    public function __construct(UserProviderInterface $userProvider, PasswordValidator $validator)
    {
        $this->userProvider = $userProvider;
        $this->validator = $validator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OAuth2Events::USER_RESOLVE => 'onUserResolve',
        ];
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (null === $user) {
            return;
        }

        if (!$user->getPassword()) {
            return;
        }

        if (!$this->validator->validate($event->getPassword(), $user->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
