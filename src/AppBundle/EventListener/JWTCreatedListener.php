<?php

// /src/AppBundle/Event/Listener/JWTCreatedListener.php

namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * Replaces the data in the generated
     *
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();

        // add new data
        $payload['userId'] = $user->getId();
        $payload['username'] = $user->getUsername();
        $payload['isAdmin'] = $user->isAdmin();
        $payload['isHq'] = $user->isHq();
        $payload['isGpv'] = $user->isGpv();

        $event->setData($payload);
    }
}