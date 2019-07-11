<?php

namespace UserBundle\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AuthenticationFailureHandler.
 *
 * @author Dev Lexik <dev@lexik.fr>
 */
class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface {

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        $event = new AuthenticationFailureEvent($exception, new JWTAuthenticationFailureResponse());

        $this->dispatcher->dispatch(Events::AUTHENTICATION_FAILURE, $event);
        return new JsonResponse(array('error'=>'Invalide user name of password'));
    }

}
