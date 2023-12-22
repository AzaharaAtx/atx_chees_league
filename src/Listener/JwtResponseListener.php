<?php

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtResponseListener
{
    public function onJWTCreated(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['user'] = [
            'id' => $user->getId(),
            'name' => $user->getFullName(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        $event->setData($data);
    }
}