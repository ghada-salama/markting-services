<?php 
namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserLocaleSubscriber implements EventSubscriberInterface
{
	private $session;
	public function __construct(SessionInterface $session)
	{
	//	die("dsd");
		$this->session = $session;
	}
	public function onLogin(InteractiveLoginEvent $event)
	{
		die("dssd");
		$user = $event->getAuthenticationToken()->getUser();
		//dump($user->getIso());die;
		if (!is_null($user->getIso())) {
			
			$this->session->set('_locale', $user->getIso());
		}
	} 
	public static function getSubscribedEvents()
	{
		return [
			SecurityEvents::INTERACTIVE_LOGIN => [
				['onLogin', 15]
			]
		];
	}
}