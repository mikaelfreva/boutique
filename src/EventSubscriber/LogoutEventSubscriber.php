<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface as EventSubscriberEventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutEventSubscriber extends AbstractController implements EventSubscriberInterface
{


public function onLogoutEvent()
{
     //$event->setResponse(new RedirectResponse($this->urlGenerator->generate('home')));
     $this->addFlash('danger', 'Au revoir ' . $this->getUser()->getEmail() . '.');

}

public static function GetSubscribedEvents()
{
    return [
        LogoutEvent::class => 'onLogoutEvent'
    ];
}


}


