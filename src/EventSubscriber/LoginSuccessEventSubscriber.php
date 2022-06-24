<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface as EventSubscriberEventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;


class LoginSuccessEventSubscriber extends AbstractController implements EventSubscriberInterface
{


private $urlGenerator;
private $entityManager;

public function __construct(UrlGeneratorInterface $urlGenerator)
{
    $this->urlGenerator = $urlGenerator;

}



public function onLoginSuccessEvent(LoginSuccessEvent $event) 
 {
   
    $event->setResponse(new RedirectResponse($this->urlGenerator->generate('account')));
     $this->addFlash('success', 'Bonjour ' . $this->getUser()->getEmail() . '.');

}

public static function GetSubscribedEvents()
{
    return [
        LoginSuccessEvent::class => 'onLoginSuccessEvent'
    ];
}


}


?>